#!/bin/sh
set -e

# Run composer scripts now that .env is available
php artisan package:discover --ansi

# Run migrations
php artisan migrate --force

# Cache config for performance
php artisan config:cache
php artisan route:cache

# Start supervisor (nginx + php-fpm)
exec /usr/bin/supervisord -c /etc/supervisord.conf
