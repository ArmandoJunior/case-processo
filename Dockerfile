FROM php:7.4.16-fpm-alpine3.13
RUN apk add --no-cache openssl bash vim
RUN set -ex \
  && apk --no-cache add \
    postgresql-dev
RUN docker-php-ext-install pdo pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz

WORKDIR /var/www
RUN rm -rf /var/www/html

RUN chown -R www-data:www-data /var/www

RUN rm //usr/local/etc/php/php.ini-development
COPY /data/php/php.ini-development /usr/local/etc/php
COPY /data/php/php.ini-production /usr/local/etc/php
COPY /data/php/php.ini /usr/local/etc/php

#COPY . /var/www
RUN ln -s public html

EXPOSE 9000
ENTRYPOINT ["php-fpm"]
