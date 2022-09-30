FROM composer:latest as build
COPY . /app/
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction

FROM php:8.1-fpm-alpine as production

ENV APP_ENV=production
ENV APP_DEBUG=false

RUN apk update && apk add \
    nginx \
    supervisor
RUN rm -rf /var/cache/apk/* && \
    rm -rf /tmp/*

RUN docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install pdo pdo_mysql
COPY docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

COPY --from=build /app /var/www
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord/supervisord.conf /etc/supervisord.conf
COPY .env.prod /var/www/.env

WORKDIR /var/www

RUN chmod 777 -R /var/www/storage/ && \
    chown -R www-data:www-data /var/www/ && \
    chmod +x /var/www/docker/run.sh

ENTRYPOINT ["/var/www/docker/run.sh"]
