#!/bin/bash

echo "Starting script..."

echo "Creating missing directories..."
mkdir -p ./storage/framework/cache
mkdir -p ./storage/framework/sessions
mkdir -p ./storage/framework/views
mkdir -p ./database/seeds
mkdir -p ./database/factories
echo "Done creating directories."

echo "Running composer update..."
composer update
echo "Done with composer update."

echo "Copying .env.example to .env..."
if [ -f "./.env.example" ]; then
    cp ./.env.example ./.env
    echo "Done copying .env file."
else
    echo ".env.example file not found."
fi

# run migrations
php artisan migrate --force

# run seeders
php artisan db:seed

# run optimize
php artisan optimize
php artisan route:clear

# scan permissions
php artisan scan:permissions

# Specific to macOS: Ensure correct permissions
echo "Setting correct permissions for macOS..."
chmod -R 755 ./storage
chmod -R 755 ./bootstrap/cache
echo "Permissions set."
