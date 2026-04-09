#!/bin/sh
set -e

echo "▶ Discovering packages..."
php artisan package:discover --ansi

echo "▶ Running migrations..."
php artisan migrate --force

echo "▶ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "▶ Starting services..."
exec /usr/bin/supervisord -c /etc/supervisord.conf
