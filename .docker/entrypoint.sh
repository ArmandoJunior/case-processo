#!/usr/bin/env bash

cp .env.example .env
composer install
chmod -R 777 storage
php artisan key:generate
php artisan cache:clear
php artisan migrate
/usr/local/startup.sh && crond -f -l 8
php-fpm
