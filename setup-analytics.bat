@echo off
echo ========================================
echo  Nail Extension Analytics Setup
echo ========================================
echo.

echo [1/5] Checking database connection...
php artisan config:clear
if errorlevel 1 (
    echo ERROR: Failed to clear config
    pause
    exit /b 1
)

echo [2/5] Creating database tables...
php artisan migrate:fresh
if errorlevel 1 (
    echo ERROR: Migration failed. Please check your database connection in .env file
    pause
    exit /b 1
)

echo [3/5] Seeding admin user and services...
echo.

echo [4/5] Generating sample customers and appointments...
php artisan db:seed
if errorlevel 1 (
    echo ERROR: Seeding failed
    pause
    exit /b 1
)

echo.
echo [5/5] Clearing cache...
php artisan cache:clear
php artisan config:clear

echo.
echo ========================================
echo  Setup Complete!
echo ========================================
echo.
echo  Admin Login:
echo  Email: admin@nailedbyvia.com
echo  Password: admin123
echo.
echo  To start the server, run:
echo  php artisan serve
echo.
echo  Then visit: http://localhost:8000/admin/login
echo ========================================
echo.

pause

