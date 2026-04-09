#!/bin/bash
set -e

# Install dependencies if vendor is missing (e.g. first deploy without cached build)
if [ ! -f "vendor/autoload.php" ]; then
    echo "▶ vendor/ not found, running composer install..."
    composer install --optimize-autoloader --no-dev --no-scripts --no-interaction
fi

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
