FROM php:8.1.0RC3-fpm-alpine3.14

LABEL maintainer="fatal.error.27@gmail.com"

RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
        $PHPIZE_DEPS \
        php8-dev \
        php8-pdo \
        php8-mysqli \
        php8-pdo_mysql \
        php8-pdo_pgsql \
        php8-pdo_sqlite \
        bash

RUN pecl install \
    xdebug-3.1.0

RUN docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql

RUN docker-php-ext-enable \
    xdebug

RUN echo Europe/Berlin > /etc/timezone

RUN mkdir /etc/nginx && \
    mkdir /etc/nginx/conf.d

COPY . /tmp/build
RUN cp /tmp/build/config/infrastructure/ini/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    cp /tmp/build/config/infrastructure/nginx/dev/logging.conf /etc/nginx/conf.d/logging.conf && \
    rm -rf /tmp/*

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R u+rw /var/www/html