# 🛡️ BoB누리 (Bobnuri)
### 모의 해킹 및 방어 실습을 위한 단계별 보안 학습 프로젝트

<p align="left">
  <img src="https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker&logoColor=white" />
  <img src="https://img.shields.io/badge/Apache-2.4-D22128?style=for-the-badge&logo=apache&logoColor=white" />
</p>

---

## 📺 Project Preview
![BoB누리 Dashboard Mockup](C:\Users\User\.gemini\antigravity\brain\5ce12136-5eac-4e75-8aba-92381b8982d5\bobnuri_mockup_1777387662525.png)
*보안 수준에 따라 변화하는 취약점을 실시간으로 학습할 수 있는 인터페이스를 제공합니다.*

---

## 📖 개요
**BoB누리**는 동일한 웹 서비스가 보안 설정(Secure Coding) 수준에 따라 어떻게 취약해지거나 견고해지는지 직접 체험할 수 있도록 설계된 **보안 학습용 샌드박스**입니다. 초보자부터 전문가까지 단계별로 모의 해킹과 방어 로직을 실습할 수 있습니다.

---

## 📊 보안 단계별 설정 (Security Levels)
사용자는 상단 메뉴의 **[Security Level]** 드롭다운을 통해 실시간으로 시스템의 보안 강도를 변경할 수 있습니다.

| 레벨 | 명칭 | 주요 특징 | 학습 포인트 |
| :--- | :--- | :--- | :--- |
| **Lv 1** | **Beginner** | **완전 취약** | 평문 저장, 기초 SQL Injection (`' OR '1'='1'`) |
| **Lv 2** | **Easy** | **문자열 필터링** | `mysqli_real_escape_string()` 우회 기법 탐색 |
| **Lv 3** | **Medium** | **취약한 해시** | MD5 복호화 및 사전 공격(Dictionary Attack) |
| **Lv 4** | **Hard** | **고급 보안** | Prepared Statements + Bcrypt 강력한 해싱 |
| **Lv 5** | **Secure** | **최종 방어** | XSS 방어 및 입출력 검증 (시큐어 코딩 완성) |

> [!TIP]
> **레벨 변경 원리**: 사용자가 메뉴를 선택하면 `SESSION`에 레벨 값이 저장되고, `security_config.php`에서 이 값을 읽어 각 취약점 지점의 실행 로직을 동적으로 분기합니다.

---

## 🚀 설치 및 실행 가이드

### 🐳 방법 1: Docker (권장)
복합한 설정 없이 명령어 한 줄로 즉시 환경을 구축합니다. (Apache Reverse Proxy 기반)

1. **저장소 복제**: 
   ```bash
   git clone https://github.com/971023als/bobnuri.git && cd bobnuri
   ```
2. **환경 변수 설정**: 
   `.env.example` 파일을 복사하여 `.env` 파일을 생성하고 필요한 설정을 변경합니다.
   ```bash
   cp .env.example .env
   ```
3. **컨테이너 실행**: 
   ```bash
   docker-compose up -d --build
   ```
4. **로컬 접속**: [http://localhost](http://localhost)

---

### 💻 방법 2: Windows XAMPP
로컬 도메인을 연동하여 실제 운영 환경처럼 테스트합니다.

1. **자동 설정 스크립트 실행**: 
   - `configure_apache.ps1` 우클릭 -> **[PowerShell에서 실행]** (관리자 권한 필수)
   - `hosts` 파일 및 Apache 가상 호스트(`mock-bobnuri.com`)를 자동 구성합니다.
2. **접속 주소**: [http://mock-bobnuri.com](http://mock-bobnuri.com)

---

## 📂 프로젝트 구조
```text
.
├── 📜 configure_apache.ps1   # XAMPP 환경 자동 설정 스크립트
├── 🛡️ security_config.php    # 보안 레벨 제어 핵심 로직
├── 🗄️ db/init.sql            # 초기 데이터베이스 스키마
├── 🐳 docker-compose.yml     # Docker 컨테이너 정의서 (Proxy + App + DB)
├── 🌐 httpd-proxy.conf       # Apache 리버스 프록시 설정
├── 🐳 Dockerfile.apache      # 프록시 서버 빌드 파일
└── 📜 scripts/               # GCP 배포 및 자동화 도구 모음
```

---

## ☁️ 클라우드 배포
GCP Compute Engine(Ubuntu) 환경에서 리버스 프록시 구조로 배포하는 상세 가이드는 아래 문서를 참고하세요.
- [👉 GCP 배포 퀵 스타트 가이드](./README_GCP_COMPUTE.md)

---

## ⚠️ 보안 주의사항
> [!CAUTION]
> 1. 본 프로젝트는 **학습용**이므로 의도적으로 취약한 코드를 포함합니다. **절대 운영 서버에 배포하지 마세요.**
> 2. 외부 인터넷 노출 시 반드시 **Level 5**를 유지하고, 실습 후에는 즉시 서비스를 종료하세요.
