#!/usr/bin/env bash

cp .env.example .env
composer install
chmod -R 777 storage
php artisan key:generate
php artisan cache:clear
php artisan migrate
echo "*       *       *       *       *       cd /var/www && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontabs/root
composer update
chmod -R 777 .
php-fpm
