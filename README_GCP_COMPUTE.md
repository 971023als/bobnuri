# Google Compute Engine Quick Start Guide (bobnuri)

## 1. 목적
이 문서는 `bobnuri` 프로젝트를 **Google Compute Engine(GCP) Ubuntu VM** 환경에서 Docker Compose를 사용하여 즉시 배포하고 테스트하기 위한 빠른 시작 가이드입니다. 
Apache Reverse Proxy를 통해 외부 80 포트를 안전하게 관리하며, 내부 PHP 앱과 MySQL은 외부에 직접 노출되지 않도록 설계되었습니다.

## 2. 최종 구성
```text
Internet
  -> [GCP External IP:80]
  -> [apache-proxy container] (Apache 2.4)
      |
      +-> [bobnuri_app container] (PHP 8.2 + Apache)
      |
      +-> [bobnuri_db container] (MySQL 8.0)
```
- **apache-proxy**: 외부 공개 진입점 (포트 80)
- **bobnuri_app**: PHP 애플리케이션, 외부 포트 미공개 (내부 80)
- **bobnuri_db**: MySQL 8.0 데이터베이스, 외부 포트 미공개 (내부 3306)

## 3. GCP Compute Engine VM 생성 조건
| 항목 | 권장값 |
| :--- | :--- |
| **OS** | Ubuntu 22.04 LTS 또는 Ubuntu 24.04 LTS |
| **Machine Type** | e2-medium 이상 |
| **Disk** | 20GB 이상 |
| **External IP** | 임시 IP 가능 (운영 시 고정 IP 권장) |
| **Firewall** | HTTP 트래픽 허용 체크 |
| **SSH** | 관리자 IP만 허용 권장 |

## 4. GCP 방화벽 설정
### 필수 (HTTP)
GCP 콘솔 또는 아래 명령어를 통해 포트 80을 개방합니다.
```bash
gcloud compute firewall-rules create allow-bobnuri-http \
  --allow tcp:80 \
  --target-tags bobnuri-web \
  --description "Allow HTTP traffic for bobnuri Apache reverse proxy"
```

### HTTPS TODO (나중에 적용)
```bash
gcloud compute firewall-rules create allow-bobnuri-https \
  --allow tcp:443 \
  --target-tags bobnuri-web \
  --description "Allow HTTPS traffic for bobnuri"
```

**주의**: TCP 3306(MySQL) 및 앱 컨테이너 포트는 절대 외부에 공개하지 마십시오. SSH(22)는 보안을 위해 관리자 IP로만 제한하는 것을 권장합니다.

## 5. VM 접속
GCP 콘솔에서 SSH 버튼을 클릭하거나 터미널에서 아래 명령어로 접속합니다.
```bash
# gcloud 사용 시
gcloud compute ssh <VM_NAME> --zone <ZONE>

# 일반 SSH 사용 시
ssh <USER>@<GCP_VM_EXTERNAL_IP>
```

## 6. 저장소 클론
```bash
sudo mkdir -p /opt
cd /opt

# 저장소 클론 (본인의 레포 주소로 변경 가능)
sudo git clone https://github.com/971023als/bobnuri.git bobnuri
sudo chown -R "$USER:$USER" /opt/bobnuri

cd /opt/bobnuri
```
*이미 클론되어 있는 경우 `git pull`로 업데이트하되, 수정 중인 파일이 있으면 중단하십시오.*

## 7. 배포 스크립트 실행
모든 인프라 설정과 컨테이너 기동을 자동화합니다.
```bash
cd /opt/bobnuri

# 스크립트 권한 부여
chmod +x scripts/bootstrap_bobnuri_vm.sh
chmod +x scripts/render_env.sh
chmod +x scripts/healthcheck.sh

# 자동 배포 스크립트 실행
sudo bash scripts/bootstrap_bobnuri_vm.sh \
  --repo-url "https://github.com/971023als/bobnuri.git" \
  --branch "main" \
  --target-dir "/opt/bobnuri" \
  --domain "app.bobnuri.local"
```

## 8. 자체 DNS / hosts 테스트
로컬 PC에서 `app.bobnuri.local` 도메인으로 접속하기 위해 hosts 파일을 수정합니다.

**Windows (C:\Windows\System32\drivers\etc\hosts):**
```text
<GCP_VM_EXTERNAL_IP> app.bobnuri.local
```

**Linux / macOS (/etc/hosts):**
```bash
sudo nano /etc/hosts
# <GCP_VM_EXTERNAL_IP> app.bobnuri.local 추가
```

**접속 URL**: `http://app.bobnuri.local`

## 9. 상태 확인
```bash
cd /opt/bobnuri

# 컨테이너 상태 확인
docker compose ps

# 설정 검증
docker compose config
docker exec apache_proxy httpd -t

# 통합 헬스체크 스크립트 실행
bash scripts/healthcheck.sh "app.bobnuri.local"
```

## 10. 중지 / 재시작 / 로그 확인
```bash
# 로그 실시간 확인
docker compose logs -f apache_proxy
docker compose logs -f app
docker compose logs -f db

# 재시작
docker compose restart

# 중지
docker compose down

# [주의] 데이터 볼륨까지 완전히 삭제 (초기화)
# docker compose down -v
```

## 11. 장애 대응 (Troubleshooting)
| 증상 | 확인 명령 | 조치 |
| :--- | :--- | :--- |
| 접속 불가 | `docker compose ps` | 컨테이너가 `Up` 상태인지 확인 |
| Apache 오류 | `docker exec apache_proxy httpd -t` | 프록시 설정 문법 확인 |
| 502 Bad Gateway | `docker compose logs app` | PHP 앱 컨테이너 기동 여부 확인 |
| DB 연결 실패 | `docker compose logs db` | `.env` 내 DB 접속 정보 확인 |
| Host 테스트 실패 | `curl -H "Host: app.bobnuri.local" ...` | hosts 파일 설정 오타 확인 |

## 12. 운영 전 보안 체크리스트
- [ ] `.env` 파일이 Git에 포함되지 않았는지 확인
- [ ] DB 포트(3306)가 외부에 노출되지 않았는지 확인
- [ ] GCP 방화벽에서 SSH(22) 포트가 관리자 IP로 제한되었는지 확인
- [ ] 운영 도메인 반영 및 HTTPS 적용
- [ ] MySQL 데이터 백업 정책 수립 및 초기 비밀번호 변경

## 13. HTTPS 적용 TODO
본 가이드는 HTTP(80) 기준입니다. 운영 배포 시에는 다음 중 하나를 선택하여 HTTPS를 적용하십시오.
1. GCP Load Balancer + Google Managed Certificate
2. Apache Proxy 컨테이너에 Let's Encrypt(Certbot) 인증서 마운트
3. Caddy 또는 Traefik 등 자동 TLS 지원 프록시로 전환

## 14. 참고: 실제 도메인 연결 방법
실제 도메인(예: example.com)을 사용하려면 DNS 설정에서 **A 레코드**를 추가하십시오.
- **Type**: A
- **Name**: bobnuri (또는 @)
- **Value**: <GCP_VM_EXTERNAL_IP>

접속: `http://bobnuri.example.com` (HTTPS 적용 후 `https://...`)
