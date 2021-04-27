FROM php:7.4.16-buster

RUN apt-get update && apt-get -y install cron postgresql docker wget
#postgresql-dev docker-php-ext-install pdo pdo_pgsql

#RUN set -ex \ && apt-get --no-cache add \ postgresql-dev
#RUN docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz

WORKDIR /var/www
RUN rm -rf /var/www/html
RUN chown -R www-data:www-data /var/www
#COPY /data/php/php.ini /usr/local/etc/php
RUN ln -s public html

# Copy mycron file to the cron.d directory
COPY cron /etc/cron.d/mycron

# Give execution rights on the cron job
RUN chmod 0744 /etc/cron.d/mycron

# Apply cron job
RUN crontab /etc/cron.d/mycron

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Run the command on container startup
CMD cron && tail -f /var/log/cron.log

EXPOSE 9000
ENTRYPOINT ["php-fpm"]
