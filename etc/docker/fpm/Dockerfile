FROM php:8.5-fpm-alpine

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN apk add --no-cache sqlite-dev \
    && docker-php-ext-install pdo_sqlite

WORKDIR /app
