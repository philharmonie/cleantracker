##########################
# COMPOSER
##########################
FROM composer:latest as build

COPY . /app/

RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction

##########################
# PHP, NGINX, SUPERVISOR
##########################
FROM php:8.1-fpm-alpine as production

ARG WWWGROUP

WORKDIR /var/www

ENV TZ=UTC
ENV APP_ENV=production
ENV APP_DEBUG=false

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apk update && apk add \
    nginx \
    supervisor \
    shadow
RUN rm -rf /var/cache/apk/* && \
    rm -rf /tmp/*

RUN docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install pdo pdo_mysql

RUN addgroup -g $WWWGROUP clean && \
    adduser -u 1337 -G clean --disabled-password --no-create-home clean

COPY --from=build /app /var/www
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord/supervisord.conf /etc/supervisord.conf
COPY docker/start-container /usr/local/bin/start-container
COPY docker/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY .env.prod /var/www/.env

RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]
