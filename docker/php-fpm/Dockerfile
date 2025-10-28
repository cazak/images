FROM php:8.1-fpm-alpine

RUN apk add --no-cache \
        git unzip \
        libpng-dev libjpeg-turbo-dev freetype-dev \
        libzip-dev icu-dev oniguruma-dev postgresql-dev \
        imagemagick-dev \
        autoconf make g++ \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql intl opcache gd zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk del autoconf make g++ \
    && mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

USER app
WORKDIR /app
