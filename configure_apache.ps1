# Bobnuri XAMPP/Apache Auto-Configuration Script (Fully Automated Edition)
# This script will self-elevate to Administrator, update hosts, config, and flush DNS.

# 0. Self-Elevation to Administrator
if (!([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")) {
    Write-Host "Requesting Administrator privileges..." -ForegroundColor Yellow
    Start-Process powershell.exe "-NoProfile -ExecutionPolicy Bypass -File `"$PSCommandPath`"" -Verb RunAs
    exit
}

$ProjectRoot = (Get-Item .).FullName
$SafeProjectRoot = $ProjectRoot.Replace('\', '/')

Write-Host "--- Bobnuri XAMPP Full Automation Setup ---" -ForegroundColor Cyan

# 1. Handle .env file
if (-not (Test-Path ".env")) {
    if (Test-Path ".env.example") {
        Copy-Item ".env.example" ".env"
        Write-Host "[OK] Created .env from .env.example" -ForegroundColor Green
    }
}

# 2. Domain & Host Setup
$Domain = "mock-bobnuri.com"
$HostsFile = "C:\Windows\System32\drivers\etc\hosts"
$HostEntry = "127.0.0.1  $Domain"

if ((Get-Content $HostsFile) -notmatch $Domain) {
    try {
        Add-Content -Path $HostsFile -Value "`r`n$HostEntry" -ErrorAction Stop
        Write-Host "[OK] Added $Domain to Windows hosts file." -ForegroundColor Green
    } catch {
        Write-Host "[ERROR] Failed to update hosts file!" -ForegroundColor Red
    }
} else {
    Write-Host "[INFO] Domain $Domain already exists in hosts file." -ForegroundColor Yellow
}

# 3. DNS Cache Flush
Write-Host "Flushing DNS Cache..." -ForegroundColor Cyan
ipconfig /flushdns | Out-Null
Write-Host "[OK] DNS Cache flushed." -ForegroundColor Green

# 4. Apache Path Detection
$ApachePath = "C:\xampp\apache"
if (-not (Test-Path $ApachePath)) {
    $ApachePath = Read-Host "Enter Apache installation path (e.g., C:\xampp\apache)"
}

$VHostsFile = Join-Path $ApachePath "conf\extra\httpd-vhosts.conf"
$HttpdConf = Join-Path $ApachePath "conf\httpd.conf"

# 5. Create VHost Block
$VHostBlock = @"

# Bobnuri Mock Hacking Project
<VirtualHost *:80>
    DocumentRoot "$SafeProjectRoot"
    ServerName $Domain
    <Directory "$SafeProjectRoot">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
"@

if ((Get-Content $VHostsFile) -notmatch "ServerName $Domain") {
    Add-Content -Path $VHostsFile -Value $VHostBlock
    Write-Host "[OK] Added VirtualHost block to $VHostsFile" -ForegroundColor Green
} else {
    Write-Host "[INFO] VirtualHost block for $Domain already exists." -ForegroundColor Yellow
}

# 6. Ensure Include vhosts is enabled in httpd.conf
$ConfContent = Get-Content $HttpdConf
$NewConfContent = @()
$Modified = $false

foreach ($line in $ConfContent) {
    if ($line -match "^\s*#\s*Include conf/extra/httpd-vhosts\.conf") {
        $NewConfContent += "Include conf/extra/httpd-vhosts.conf"
        $Modified = $true
    } else {
        $NewConfContent += $line
    }
}

if ($Modified) {
    Set-Content -Path $HttpdConf -Value $NewConfContent
    Write-Host "[OK] Un-commented Include vhosts in httpd.conf" -ForegroundColor Green
}

# 7. Attempt to Restart Apache (if it's a service)
Write-Host "Attempting to restart Apache service..." -ForegroundColor Cyan
$Service = Get-Service -Name "Apache*" -ErrorAction SilentlyContinue
if ($Service) {
    Restart-Service $Service.Name
    Write-Host "[OK] Apache service restarted." -ForegroundColor Green
} else {
    Write-Host "[INFO] Apache is not installed as a service. Please restart it manually via XAMPP Control Panel." -ForegroundColor Yellow
}

Write-Host "`n--- All Automations Complete! ---" -ForegroundColor Cyan
Write-Host "Access your site at: http://$Domain" -ForegroundColor Green
Write-Host "Press any key to exit..."
$null = [Console]::ReadKey()
