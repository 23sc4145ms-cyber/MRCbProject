@echo off
echo ========================================
echo FIXING STUDENTS TABLE - URGENT FIX
echo ========================================
echo.

REM Stop Laravel server if running
echo Attempting to stop Laravel server...
taskkill /F /IM php.exe 2>nul
timeout /t 2 /nobreak >nul

echo.
echo Running database fix...
echo.

REM Run the SQL fix
mysql -u root -p mrclaravelDb < URGENT_FIX.sql

echo.
echo ========================================
echo FIX COMPLETED!
echo ========================================
echo.
echo Now start your Laravel server again:
echo php artisan serve
echo.
pause
