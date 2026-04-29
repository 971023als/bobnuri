#!/usr/bin/env bash
set -euo pipefail

DOMAIN="bobnuri.o-r.kr"

echo "== HTTPS / Let's Encrypt 인증서 점검 시작 =="
echo "DOMAIN: $DOMAIN"

echo
echo "== 1. Certbot 인증서 목록 확인 =="
if command -v certbot >/dev/null 2>&1; then
  sudo certbot certificates || true
else
  echo "WARN: certbot 명령어가 없습니다."
fi

echo
echo "== 2. HTTP 응답 확인 =="
curl -I "http://$DOMAIN" || true

echo
echo "== 3. HTTPS 외부 DNS 기준 테스트 =="
if curl -I "https://$DOMAIN"; then
  echo "OK: HTTPS 외부 접속 성공"
else
  echo "WARN: HTTPS 외부 접속 실패"
  echo "- DNS A 레코드가 서버 공인 IP를 가리키는지 확인"
  echo "- GCP 방화벽에서 tcp:443 허용 여부 확인"
  echo "- Apache/Nginx 443 VirtualHost 설정 확인"
fi

echo
echo "== 4. HTTPS 내부 localhost 강제 매핑 테스트 =="
if curl -I --resolve "$DOMAIN:443:127.0.0.1" "https://$DOMAIN"; then
  echo "OK: 내부 HTTPS 인증서 검증 성공"
else
  echo "WARN: 내부 HTTPS 테스트 실패"
  echo "- SSL VirtualHost가 $DOMAIN 기준으로 잡혀 있는지 확인"
  echo "- 인증서 경로가 올바른지 확인"
fi

echo
echo "== 5. localhost HTTPS 단순 응답 확인 =="
if curl -k -I https://localhost; then
  echo "OK: localhost HTTPS 응답 존재"
else
  echo "WARN: localhost HTTPS 응답 없음"
fi

echo
echo "== 6. 인증서 파일/SAN 확인 =="
CERT_PATH="/etc/letsencrypt/live/$DOMAIN/fullchain.pem"

if [ -f "$CERT_PATH" ]; then
  sudo openssl x509 -in "$CERT_PATH" -noout -subject -issuer -dates
  echo
  sudo openssl x509 -in "$CERT_PATH" -noout -text | grep -A2 "Subject Alternative Name" || true
else
  echo "WARN: 인증서 파일을 찾지 못했습니다: $CERT_PATH"
  echo
  echo "현재 Let's Encrypt live 디렉터리:"
  sudo ls -la /etc/letsencrypt/live/ || true
fi

echo
echo "== 7. Apache/Nginx 상태 확인 =="
if command -v apache2ctl >/dev/null 2>&1; then
  sudo apache2ctl -S || true
  sudo systemctl status apache2 --no-pager -l || true
fi

if command -v nginx >/dev/null 2>&1; then
  sudo nginx -T 2>/dev/null | grep -E "server_name|ssl_certificate" || true
  sudo systemctl status nginx --no-pager -l || true
fi

echo
echo "== 8. 80/443 포트 리스닝 확인 =="
sudo ss -lntp | grep -E ':80|:443' || {
  echo "WARN: 80 또는 443 포트 리스닝 프로세스를 찾지 못했습니다."
}

echo
echo "== 점검 완료 =="
