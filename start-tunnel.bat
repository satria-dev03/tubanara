@echo off
TITLE Cloudflare Tunnel - Satria ERP
COLOR 0A

echo ===================================================
echo     STARTING CLOUDFLARE TUNNEL FOR SATRIA ERP
echo ===================================================
echo.

:: Pindah ke direktori tempat skrip ini berada
cd /d "%~dp0"

:: Jalankan Cloudflare Tunnel khusus Laravel Herd
echo Menghubungkan satria-erp.test ke internet via Cloudflare Tunnel...
echo.
echo Catatan:
echo 1. Salin URL https://xxx.trycloudflare.com yang muncul di bawah ini.
echo 2. Update APP_URL dan ASSET_URL di file .env Anda jika URL berubah.
echo.
echo Tekan CTRL + C untuk menghentikan tunnel.
echo ===================================================
echo.

cloudflared.exe tunnel --url https://tubanara.test --http-host-header tubanara.test --no-tls-verify

pause