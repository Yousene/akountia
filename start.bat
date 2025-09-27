@echo off

echo Starting script...

echo Creating missing directories...
mkdir .\storage\framework
mkdir .\storage\framework\cache
mkdir .\storage\framework\sessions
mkdir .\storage\framework\views
mkdir .\database\seeds
mkdir .\database\factories
echo Done creating directories.

echo Running composer update...
call composer update
echo Done with composer update.

echo Copying .env.example to .env...
if exist .\.env.example (
    copy /Y .\.env.example .\.env
    echo Done copying .env file.
) else (
    echo .env.example file not found.
)


REM run migrations
php artisan migrate --force

REM run seeders
php artisan db:seed

REM run optimize
php artisan optimize
php artisan route:clear

REM Scan Permissions
php artisan scan:permissions 