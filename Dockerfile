FROM php:8.4-cli-bookworm

WORKDIR /var/www/html

ARG WWWGROUP=1000
ARG WWWUSER=1000

RUN docker-php-ext-install pdo_mysql \
    && groupadd --gid "${WWWGROUP}" sail \
    && useradd --uid "${WWWUSER}" --gid sail --create-home --shell /bin/bash sail

USER sail

EXPOSE 80

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]