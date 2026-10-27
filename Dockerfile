# syntax=docker/dockerfile:1

ARG PHP_VERSION=8.4

# ---------------------------------------------------------------------------
# Stage: PHP dependencies
# ---------------------------------------------------------------------------
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --ignore-platform-reqs

COPY . .
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --ignore-platform-reqs

# ---------------------------------------------------------------------------
# Stage: frontend assets
# ---------------------------------------------------------------------------
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

# ---------------------------------------------------------------------------
# Stage: runtime image (nginx + php-fpm, managed by supervisord)
# ---------------------------------------------------------------------------
FROM php:${PHP_VERSION}-fpm-alpine AS runtime

RUN apk add --no-cache \
        nginx \
        supervisor \
        bash \
        icu-libs \
        libzip \
        libpng \
        oniguruma \
    && apk add --no-cache --virtual .build-deps \
        icu-dev \
        libzip-dev \
        libpng-dev \
        oniguruma-dev \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        bcmath \
        exif \
        pcntl \
        gd \
        zip \
        intl \
        opcache \
    && apk del --no-cache .build-deps

WORKDIR /var/www/html

COPY --from=vendor /app/vendor ./vendor
COPY . .
COPY --from=frontend /app/public/build ./public/build

COPY docker/php/production.ini $PHP_INI_DIR/conf.d/zz-app.ini
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN mkdir -p storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/testing \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
