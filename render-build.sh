#!/usr/bin/env bash
# exit on error
set -o errexit

echo "Starting build process..."

# 1. Install PHP dependencies
echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# 2. Clear caches
echo "Clearing caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Create Storage Link for product images
echo "Linking storage directory..."
php artisan storage:link || true

# 4. Run database migrations
echo "Running database migrations..."
php artisan migrate --force

echo "Build process completed successfully!"
