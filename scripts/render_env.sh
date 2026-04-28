#!/bin/bash
# render_env.sh - Safely generate .env from .env.example

set -Eeuo pipefail

ENV_FILE=".env"
EXAMPLE_FILE=".env.example"

# Check if .env.example exists
if [ ! -f "$EXAMPLE_FILE" ]; then
    echo "Error: $EXAMPLE_FILE not found."
    exit 1
fi

# Check if .env already exists
if [ -f "$ENV_FILE" ]; then
    echo ".env already exists. Skipping generation to prevent overwriting secrets."
    exit 0
fi

echo "Generating .env from $EXAMPLE_FILE..."

# Generate random passwords
DB_PASS=$(openssl rand -base64 16)
ROOT_PASS=$(openssl rand -base64 16)

# Create .env and substitute values
sed -e "s/CHANGE_ME_STRONG_PASSWORD/$DB_PASS/g" \
    -e "s/CHANGE_ME_ROOT_PASSWORD/$ROOT_PASS/g" \
    "$EXAMPLE_FILE" > "$ENV_FILE"

chmod 600 "$ENV_FILE"
echo ".env generated and secured (chmod 600)."
