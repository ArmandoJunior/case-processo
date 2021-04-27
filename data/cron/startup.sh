#!/bin/sh
echo "*       *       *       *       *       cd /var/www && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontabs/root
crontab -l
