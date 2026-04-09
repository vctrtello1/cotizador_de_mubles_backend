# ---- Composer stage ----
FROM php:8.4-fpm-alpine3.21 AS vendor

RUN apk add --no-cache unzip curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader --no-scripts

# ---- Runtime stage ----
FROM php:8.4-fpm-alpine3.21

RUN apk add --no-cache \
    libpng-dev libxml2-dev oniguruma-dev postgresql-dev libzip-dev \
    nginx supervisor curl unzip bash \
    freetype-dev libjpeg-turbo-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
       pdo pdo_pgsql pdo_mysql \
       mbstring zip gd bcmath opcache dom xml curl exif pcntl

RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www

COPY --chown=www-data:www-data . .
COPY --from=vendor --chown=www-data:www-data /app/vendor ./vendor
COPY --from=vendor /usr/local/bin/composer /usr/local/bin/composer

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh \
    && chmod -R 755 /var/www/storage \
    && chmod -R 755 /var/www/bootstrap/cache

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
