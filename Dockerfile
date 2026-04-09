# ─── Stage 1: Install Composer dependencies ───────────────────────────────────
FROM php:8.3-fpm-alpine3.21 AS vendor

RUN apk add --no-cache unzip curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --optimize-autoloader \
    --no-dev \
    --no-scripts \
    --no-interaction \
    --ignore-platform-reqs

# ─── Stage 2: Final image ──────────────────────────────────────────────────────
FROM php:8.3-fpm-alpine3.21

# Install system dependencies
RUN apk add --no-cache \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    postgresql-dev \
    nginx \
    supervisor \
    curl \
    unzip \
    bash

# Install PHP extensions
RUN docker-php-ext-install \
    pdo pdo_pgsql pdo_mysql \
    mbstring exif pcntl bcmath \
    gd xml dom opcache

# Optimize PHP for production
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www

# Copy application code
COPY --chown=www-data:www-data . .

# Copy vendor from stage 1
COPY --from=vendor --chown=www-data:www-data /app/vendor ./vendor

# Copy config files
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
