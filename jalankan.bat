@echo off
chcp 65001 >nul
cd /d "%~dp0"
if not exist vendor\autoload.php (
  echo Folder vendor belum ada.
  echo Salin dulu folder vendor dari website-nu2 ke dalam folder ini lewat File Explorer.
  pause
  exit /b 1
)
echo Menjalankan website di http://127.0.0.1:8000  ^(tutup jendela ini untuk berhenti^)
start "" cmd /c "timeout /t 3 >nul & start http://127.0.0.1:8000"
php artisan serve
pause
