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

RUN apk update && apk add tzdata &&\
    cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime &&\
    echo "America/Sao_Paulo" > /etc/timezone &&\
    apk del tzdata && rm -rf /var/cache/apk/*

## Copy mycron file to the cron.d directory
COPY data/cron/startup.sh /usr/local/startup.sh

# Run the command on container startup
CMD cron && tail -f /var/log/cron.log
CMD /usr/local/startup.sh && crond -f -l 8

#CMD ['/usr/local/startup.sh', 'crond', '-l 8', '-f']
CMD [ "/usr/sbin/crond", "-f", "-d8" ]

EXPOSE 9000
ENTRYPOINT ["php-fpm"]
