#!/usr/bin/env bash
set -euo pipefail

REPO_DIR="/home/g971023als/bobnuri"
BRANCH="main"
REMOTE_EXPECTED="https://github.com/971023als/bobnuri.git"
LOG_FILE="$REPO_DIR/auto_git_push.log"

cd "$REPO_DIR"

{
  echo "============================================================"
  echo "[$(date '+%Y-%m-%d %H:%M:%S')] auto git push started"

  if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
    echo "ERROR: not a git repository"
    exit 1
  fi

  CURRENT_BRANCH="$(git branch --show-current)"
  if [ "$CURRENT_BRANCH" != "$BRANCH" ]; then
    echo "ERROR: current branch is $CURRENT_BRANCH, expected $BRANCH"
    exit 1
  fi

  REMOTE_URL="$(git remote get-url origin)"
  if [ "$REMOTE_URL" != "$REMOTE_EXPECTED" ]; then
    echo "ERROR: unexpected remote url: $REMOTE_URL"
    exit 1
  fi

  # 민감정보 파일 자동 푸시 차단
  if git status --short | grep -Ei '(^|\s)(\.env|\.env\..*|.*\.pem|.*\.key|.*id_rsa.*|.*credentials.*|.*secret.*|.*token.*|ssl/|certs/)' >/dev/null 2>&1; then
    echo "ERROR: possible sensitive file detected. auto push stopped."
    git status --short
    exit 1
  fi

  if [ -z "$(git status --porcelain)" ]; then
    echo "No changes."
    exit 0
  fi

  git pull --rebase origin "$BRANCH"
  git add .
  git commit -m "auto: sync changes $(date '+%Y-%m-%d %H:%M:%S')"
  git push origin "$BRANCH"

  echo "[$(date '+%Y-%m-%d %H:%M:%S')] pushed successfully"
} >> "$LOG_FILE" 2>&1
