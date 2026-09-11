FROM php:8.5-fpm-alpine

RUN addgroup --gid 1000 --system systemuser \
    && adduser --uid 1000 --system --ingroup systemuser systemuser \
    && php -r 'exit(extension_loaded("pdo_sqlite") ? 0 : 1);'

WORKDIR /app

COPY etc/docker/fpm/entrypoint.sh /entrypoint.sh
COPY etc/docker/fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN chmod +x /entrypoint.sh

USER systemuser

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
