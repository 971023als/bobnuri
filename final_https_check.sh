#!/usr/bin/env bash
set -u

DOMAIN="bobnuri.o-r.kr"
CERT_DIR="/etc/letsencrypt/live/$DOMAIN"
CERT_FULLCHAIN="$CERT_DIR/fullchain.pem"
CERT_PRIVKEY="$CERT_DIR/privkey.pem"

echo "=================================================="
echo " BoBnuri HTTPS / Docker Proxy Final Check"
echo " DOMAIN: $DOMAIN"
echo "=================================================="

echo
echo "== 1. Host apache2 서비스 비활성화 =="
echo "- 현재 80/443 포트는 Docker apache_proxy가 사용해야 합니다."
echo "- Host apache2가 켜지면 포트 충돌이 날 수 있으므로 중지/비활성화합니다."

if systemctl list-unit-files | grep -q '^apache2\.service'; then
  sudo systemctl stop apache2 2>/dev/null || true
  sudo systemctl disable apache2 2>/dev/null || true
  echo "OK: apache2 stop/disable 처리 완료"
else
  echo "INFO: apache2.service가 없습니다."
fi

echo
echo "== 2. Docker 컨테이너 상태 확인 =="
sudo docker ps --format 'table {{.Names}}\t{{.Status}}\t{{.Ports}}' || {
  echo "WARN: docker ps 실행 실패"
}

echo
echo "== 3. 80/443 포트 리스닝 확인 =="
sudo ss -lntp | grep -E ':80|:443' || {
  echo "WARN: 80 또는 443 리스닝 프로세스를 찾지 못했습니다."
}

echo
echo "== 4. Certbot 인증서 목록 확인 =="
if command -v certbot >/dev/null 2>&1; then
  sudo certbot certificates || true
else
  echo "WARN: certbot 명령어가 없습니다."
fi

echo
echo "== 5. Let's Encrypt 인증서 파일/링크 확인 =="
echo "CERT_DIR: $CERT_DIR"

if [ -d "$CERT_DIR" ]; then
  sudo ls -la "$CERT_DIR"

  echo
  echo "fullchain.pem 실제 경로:"
  sudo readlink -f "$CERT_FULLCHAIN" || true

  echo
  echo "privkey.pem 실제 경로:"
  sudo readlink -f "$CERT_PRIVKEY" || true

  echo
  echo "archive 디렉터리:"
  sudo ls -la "/etc/letsencrypt/archive/$DOMAIN" || true
else
  echo "WARN: 인증서 디렉터리가 없습니다: $CERT_DIR"
fi

echo
echo "== 6. 인증서 상세 정보 확인 =="
if sudo test -e "$CERT_FULLCHAIN"; then
  sudo openssl x509 -in "$CERT_FULLCHAIN" -noout -subject -issuer -dates || true
  echo
  sudo openssl x509 -in "$CERT_FULLCHAIN" -noout -text | grep -A2 "Subject Alternative Name" || true
else
  echo "WARN: 인증서 파일을 찾지 못했습니다: $CERT_FULLCHAIN"
fi

echo
echo "== 7. HTTP → HTTPS 리다이렉트 확인 =="
echo "curl -I http://$DOMAIN"
curl -I "http://$DOMAIN" || {
  echo "WARN: HTTP 접속 확인 실패"
}

echo
echo "== 8. HTTPS 외부 DNS 기준 확인 =="
echo "curl -I https://$DOMAIN"
if curl -I "https://$DOMAIN"; then
  echo "OK: HTTPS 외부 접속 성공"
else
  echo "WARN: HTTPS 외부 접속 실패"
fi

echo
echo "== 9. HTTPS 내부 localhost 강제 매핑 확인 =="
echo "curl -I --resolve $DOMAIN:443:127.0.0.1 https://$DOMAIN"
if curl -I --resolve "$DOMAIN:443:127.0.0.1" "https://$DOMAIN"; then
  echo "OK: 내부 HTTPS 인증서 검증 성공"
else
  echo "WARN: 내부 HTTPS 인증서 검증 실패"
fi

echo
echo "== 10. localhost HTTPS 단순 응답 확인 =="
echo "주의: localhost는 인증서 이름 불일치가 정상일 수 있으므로 -k로 응답만 확인합니다."
if curl -k -I https://localhost; then
  echo "OK: localhost HTTPS 응답 존재"
else
  echo "WARN: localhost HTTPS 응답 없음"
fi

echo
echo "== 11. 최종 요약 =="
HTTP_STATUS="$(curl -s -o /dev/null -w '%{http_code}' "http://$DOMAIN" || echo 'ERR')"
HTTPS_STATUS="$(curl -s -o /dev/null -w '%{http_code}' "https://$DOMAIN" || echo 'ERR')"
LOCAL_RESOLVE_STATUS="$(curl -s -o /dev/null -w '%{http_code}' --resolve "$DOMAIN:443:127.0.0.1" "https://$DOMAIN" || echo 'ERR')"

echo "HTTP status              : $HTTP_STATUS"
echo "HTTPS status             : $HTTPS_STATUS"
echo "Local resolve HTTPS      : $LOCAL_RESOLVE_STATUS"

if [ "$HTTPS_STATUS" = "200" ] && [ "$LOCAL_RESOLVE_STATUS" = "200" ]; then
  echo
  echo "RESULT: OK - HTTPS 배포 정상"
  echo "- https://$DOMAIN 접속 성공"
  echo "- Docker apache_proxy가 80/443 처리 중"
  echo "- Host apache2 포트 충돌 방지 처리 완료"
else
  echo
  echo "RESULT: CHECK_NEEDED - 일부 항목 확인 필요"
  echo "- docker ps"
  echo "- ss -lntp | grep -E ':80|:443'"
  echo "- sudo certbot certificates"
fi

echo
echo "== 완료 =="
