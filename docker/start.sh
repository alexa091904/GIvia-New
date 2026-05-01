#!/bin/sh
set -e

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Cache config, routes, and views for performance
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Link storage directory
php artisan storage:link || true

# Run database migrations
php artisan migrate --force || true

# Start supervisor (manages nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisord.conf
