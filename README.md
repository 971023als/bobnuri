# 🛡️ BoB누리 (Bobnuri) - 모의 해킹 및 방어 실습 프로젝트

BoB누리 실습 프로젝트에 오신 것을 환영합니다! 이 프로젝트는 **모의 해킹 실습 및 보안 방어**를 학습하기 위한 웹 애플리케이션입니다. 단계별 보안 설정을 통해 동일한 기능이 보안 수준에 따라 어떻게 취약해지거나 견고해지는지 직접 체험할 수 있습니다.

---

## 📑 목차 (Table of Contents)
1. [보안 단계별 설정 (Difficulty Levels)](#-보안-단계별-설정-difficulty-levels)
2. [설치 및 환경 구축](#-설치-및-환경-구축-가이드)
   - [방법 1: Docker (권장)](#방법-1-docker-사용-권장-및-가장-빠름)
   - [방법 2: Windows XAMPP](#방법-2-windows-xampp-환경-로컬-도메인-연동)
3. [📂 프로젝트 구조](#-프로젝트-구조)
4. [☁️ 배포 가이드](#-배포-가이드-deployment)
5. [⚠️ 최종 보안 주의사항](#-최종-보안-주의사항)

---

## 📊 보안 단계별 설정 (Difficulty Levels)

학습자는 상단 메뉴를 통해 실시간으로 보안 레벨을 변경할 수 있습니다.

| 단계 | 명칭 | 주요 보안 기능 및 학습 포인트 |
| :--- | :--- | :--- |
| **Level 1** | **Beginner** | **완전 취약 상태**: 평문 비밀번호 저장. 기초적인 SQL Injection (`' OR '1'='1'`)을 통한 인증 우회 실습. |
| **Level 2** | **Easy** | **기초 방어**: `mysqli_real_escape_string()` 필터링 적용. 필터링을 우회할 수 있는 다른 취약점 탐색. |
| **Level 3** | **Medium** | **취약한 암호화**: MD5 해시 적용. 레인보우 테이블이나 사전 공격(Dictionary Attack)을 통한 복호화 사례 학습. |
| **Level 4** | **Hard** | **고급 보안**: Prepared Statements + Bcrypt 강력한 해싱. SQLi가 완벽히 차단되는 원리 확인. |
| **Level 5** | **Secure** | **최종 방어**: XSS 방어(`htmlspecialchars`) 및 입출력 검증 강화. 완벽한 시큐어 코딩 설계 학습. |

---

## 🚀 설치 및 환경 구축 가이드

### 방법 1: Docker 사용 (권장 및 가장 빠름)
가장 간편하게 전체 환경을 구축하고 외부에서도 접속할 수 있는 방법입니다.

1. **저장소 복제**: `git clone https://github.com/971023als/bobnuri.git && cd bobnuri`
2. **컨테이너 실행**: `docker-compose up -d --build`
3. **로컬 접속**: [http://localhost:8080](http://localhost:8080)
4. **외부 기기(모바일 등) 및 포트 포워딩 접속 가이드**
   - **내부 IP 고정**: `ipconfig /all`로 확인한 MAC 주소를 공유기 [DHCP 고정 할당]에 등록.
   - **포트 포워딩**: 외부 포트(예: 8080) -> 내부 포트(8080) -> PC 내부 IP 설정.
   - **방화벽 개방**: Windows `wf.msc`에서 TCP 8080 인바운드 규칙 허용.
   - **접속 테스트**: 스마트폰 LTE 환경에서 `http://[공인IP]:8080`으로 접속.
   - **DDNS 활용**: iptime 등 공유기 DDNS 기능을 통해 `아이디.iptime.org:8080` 주소 사용 가능.

---

### 방법 2: Windows XAMPP 환경 (로컬 도메인 연동)
실제 도메인(`mock-bobnuri.com`)을 사용하여 운영 환경처럼 실습하고 싶을 때 유용합니다.

1. **자동화 스크립트 실행**: `configure_apache.ps1` 우클릭 -> **[PowerShell에서 실행]** (관리자 권한 필요).
   - `hosts` 파일 등록 및 아파치 가상 호스트 설정을 자동으로 수행합니다.
2. **접속 주소**: [http://mock-bobnuri.com](http://mock-bobnuri.com)
3. **외부 인터넷 접속 및 트러블슈팅**
   - **포트 충돌**: 아파치 실행 실패 시 `80` 포트를 쓰는 프로그램(IIS, Skype 등) 종료.
   - **공유기 설정**: 외부 포트(80)를 PC 내부 IP로 포트 포워딩.
   - **방화벽 설정**: Windows 인바운드 규칙에서 `80` 포트 차단 해제 필수.
   - **테스트**: LTE 환경에서 `http://[공인IP]` 또는 `http://[DDNS주소]` 접속 확인.

---

## 📂 프로젝트 구조
- 📜 `configure_apache.ps1`: XAMPP 환경 자동 설정 스크립트.
- 🛡️ `security_config.php`: 보안 레벨 및 `.env` 로드 핵심 로직.
- 🗄️ `db/init.sql`: 초기 DB 스키마 및 샘플 데이터.
- 🐳 `docker-compose.yml`: 멀티 컨테이너 정의서.
- 📜 `scripts/`: GCP 배포 자동화 및 헬스체크 스크립트 모음.

---

## ☁️ 배포 가이드 (Deployment)

### Google Compute Engine (GCP)
GCP Ubuntu VM에서 리버스 프록시 구조로 안전하게 배포하는 방법은 아래 상세 문서를 참고하세요.
- [👉 GCP 배포 퀵 스타트 가이드 (README_GCP_COMPUTE.md)](./README_GCP_COMPUTE.md)

---

## 🛡️ 최종 보안 주의사항
> [!CAUTION]
> **본 프로젝트는 학습용으로 설계되어 의도적으로 매우 취약한 코드를 포함하고 있습니다.**
> 1. 절대 실제 운영 서버에 그대로 배포하지 마십시오.
> 2. 실습 직후에는 반드시 공유기 규칙을 삭제하고 서비스를 종료하십시오.
> 3. 외부 인터넷에 노출해야 할 경우 보안 레벨을 항상 **Level 5**로 유지하십시오.
