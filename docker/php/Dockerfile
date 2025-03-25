FROM php:8.4-fpm-alpine3.21

ENV DB_HOST ''
ENV DB_NAME ''
ENV DB_USER ''
ENV DB_PASS ''
ENV DB_PORT ''

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY site/ /var/www

WORKDIR /var/www

RUN docker-php-ext-install pdo pdo_mysql && \
    composer install