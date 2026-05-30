FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl

COPY php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /var/www/html