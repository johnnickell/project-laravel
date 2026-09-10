FROM node:24-bookworm-slim AS node

FROM php:8.5-cli-bookworm

RUN apt-get update \
    && apt-get install --no-install-recommends --yes \
        $PHPIZE_DEPS \
        git \
        python3 \
        rsync \
        sqlite3 \
        unzip \
    && pecl install pcov \
    && docker-php-ext-enable pcov \
    && apt-get purge --auto-remove --yes $PHPIZE_DEPS \
    && rm -rf /var/lib/apt/lists/* /tmp/pear

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node /usr/local/ /usr/local/

RUN php -r 'exit(extension_loaded("pdo_sqlite") ? 0 : 1);'

WORKDIR /app
