FROM php:8.2-cli-alpine

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/custom.ini

RUN apk add --no-cache \
        git unzip autoconf build-base \
        nodejs npm \
        libzip-dev icu-dev libpng-dev libjpeg-turbo-dev freetype-dev postgresql-dev \
        imagemagick-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql intl zip gd opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk del autoconf build-base

RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

USER app
WORKDIR /app
