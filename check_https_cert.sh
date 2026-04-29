#!/usr/bin/env bash
set -euo pipefail

DOMAIN="bobnuri.o-r.kr"

echo "== HTTPS / Let's Encrypt 인증서 점검 =="
echo "DOMAIN: $DOMAIN"
echo

echo "== 1. Docker 컨테이너 상태 =="
docker ps --format 'table {{.Names}}\t{{.Status}}\t{{.Ports}}' || true
echo

echo "== 2. 80/443 포트 리스닝 =="
ss -lntp | grep -E ':80|:443' || true
echo

echo "== 3. HTTP → HTTPS 리다이렉트 확인 =="
curl -I "http://$DOMAIN" || true
echo

echo "== 4. HTTPS 외부 접속 확인 =="
curl -I "https://$DOMAIN" || true
echo

echo "== 5. 인증서 상세 확인 =="
echo | openssl s_client -connect "$DOMAIN:443" -servername "$DOMAIN" 2>/dev/null \
  | openssl x509 -noout -subject -issuer -dates || true
echo

echo "== 6. Certbot 인증서 목록 =="
if command -v certbot >/dev/null 2>&1; then
  sudo certbot certificates || true
else
  echo "certbot not found"
fi
