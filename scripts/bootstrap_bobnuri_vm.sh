#!/bin/bash
# bootstrap_bobnuri_vm.sh - GCP Ubuntu VM Deployment Automation

set -Eeuo pipefail

# --- Configuration ---
REPO_URL=""
BRANCH="main"
TARGET_DIR="/opt/bobnuri"
DOMAIN="app.bobnuri.local"

# --- Functions ---
log() { echo -e "\033[1;32m[INFO] $1\033[0m"; }
warn() { echo -e "\033[1;33m[WARN] $1\033[0m"; }
die() { echo -e "\033[1;31m[ERROR] $1\033[0m"; exit 1; }

require_root_or_sudo() {
    if [[ $EUID -ne 0 ]]; then
        die "This script must be run with sudo."
    fi
}

command_exists() {
    command -v "$1" >/dev/null 2>&1
}

install_docker_if_missing() {
    if ! command_exists docker; then
        log "Installing Docker..."
        apt-get update
        apt-get install -y ca-certificates curl gnupg
        install -m 0755 -d /etc/apt/keyrings
        curl -fsSL https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
        chmod a+r /etc/apt/keyrings/docker.gpg
        echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | tee /etc/apt/sources.list.d/docker.list > /dev/null
        apt-get update
        apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
    else
        log "Docker is already installed."
    fi
}

clone_or_update_repo() {
    if [ ! -d "$TARGET_DIR" ]; then
        log "Cloning repository to $TARGET_DIR..."
        git clone -b "$BRANCH" "$REPO_URL" "$TARGET_DIR"
    else
        log "Updating repository in $TARGET_DIR..."
        cd "$TARGET_DIR"
        if [ -n "$(git status --porcelain)" ]; then
            die "Uncommitted changes found in $TARGET_DIR. Aborting for safety."
        fi
        git pull origin "$BRANCH"
    fi
}

generate_env_if_missing() {
    cd "$TARGET_DIR"
    bash scripts/render_env.sh
}

validate_compose() {
    cd "$TARGET_DIR"
    log "Validating docker-compose configuration..."
    docker compose config > /dev/null || die "Docker Compose configuration is invalid."
}

start_stack() {
    cd "$TARGET_DIR"
    log "Starting containers..."
    docker compose up -d --build
}

# --- Main Logic ---
while [[ $# -gt 0 ]]; do
    case $1 in
        --repo-url) REPO_URL="$2"; shift 2 ;;
        --branch) BRANCH="$2"; shift 2 ;;
        --target-dir) TARGET_DIR="$2"; shift 2 ;;
        --domain) DOMAIN="$2"; shift 2 ;;
        *) shift ;;
    esac
done

if [ -z "$REPO_URL" ]; then
    die "Usage: sudo bash $0 --repo-url <URL> [--branch <branch>] [--target-dir <dir>] [--domain <domain>]"
fi

require_root_or_sudo
install_docker_if_missing
clone_or_update_repo
generate_env_if_missing
validate_compose
start_stack

log "Deployment successful!"
bash scripts/healthcheck.sh "$DOMAIN"
