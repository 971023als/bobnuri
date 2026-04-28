#!/bin/bash
# healthcheck.sh - Post-deployment validation script

set -Euo pipefail

DOMAIN=${1:-"app.bobnuri.local"}

log() { echo -e "\033[1;32m[HEALTHCHECK] $1\033[0m"; }
error() { echo -e "\033[1;31m[FAILED] $1\033[0m"; }

echo "------------------------------------------------"
echo " Bobnuri Deployment Healthcheck "
echo "------------------------------------------------"

# 1. Container Status
log "Checking container status..."
docker compose ps --format "table {{.Name}}\t{{.Status}}\t{{.Ports}}"

# 2. Apache Configuration
log "Validating Apache configuration..."
if docker exec apache_proxy httpd -t; then
    echo "Apache config: OK"
else
    error "Apache config: ERROR"
fi

# 3. Local Connectivity
log "Testing local connectivity (localhost:80)..."
if curl -I -s http://127.0.0.1 | grep -q "HTTP/1.1"; then
    echo "Local connectivity: OK"
else
    error "Local connectivity: FAILED"
fi

# 4. Host Header Connectivity
log "Testing Domain connectivity ($DOMAIN)..."
if curl -I -s -H "Host: $DOMAIN" http://127.0.0.1 | grep -q "HTTP/1.1"; then
    echo "Domain connectivity ($DOMAIN): OK"
else
    error "Domain connectivity ($DOMAIN): FAILED"
fi

# 5. Application Logs
log "Recent Application Logs (bobnuri_app)..."
docker logs --tail=10 bobnuri_app

echo "------------------------------------------------"
echo "Healthcheck complete."
