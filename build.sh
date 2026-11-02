#!/usr/bin/env bash
# Exit on error
set -o errexit

echo "--- Installing PHP dependencies ---"
composer install --no-dev --optimize-autoloader --no-interaction

echo "--- Installing & Building Frontend (Vue 3 + Vite) ---"
npm install
npm run build

echo "--- Setting up SQLite Database ---"
mkdir -p database
touch database/database.sqlite

echo "--- Running Migrations ---"
php artisan migrate --force

echo "--- Optimizing Laravel Cache ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Build Finished Successfully! ---"
