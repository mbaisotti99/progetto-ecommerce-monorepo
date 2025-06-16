@echo off
setlocal enabledelayedexpansion

REM Salva la directory corrente del batch file
set "ROOT=%~dp0"

REM Rimuove il trailing backslash se presente
set "ROOT=%ROOT:~0,-1%"

echo [1/5] Setup backoffice...

cd /d "%ROOT%\backoffice"

echo Installing PHP dependencies...
call composer install

echo Installing Node dependencies...
call npm install

echo Linking storage
php artisan storage:link  

echo Starting Laravel backoffice server...
start "Backoffice PHP" cmd /k cd /d "%ROOT%\backoffice" ^&^& php artisan serve

echo Starting Laravel Vite (npm run dev)...
start "Backoffice Vite" cmd /k cd /d "%ROOT%\backoffice" ^&^& npm run dev

echo [2/5] Setup frontoffice...

cd /d "%ROOT%\frontoffice"

echo Installing frontoffice Node dependencies...
call npm install

echo Starting React frontoffice (npm run dev)...
start "Frontoffice" cmd /k cd /d "%ROOT%\frontoffice" ^&^& npm run dev

echo Tutto avviato!  