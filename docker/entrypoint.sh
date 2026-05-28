#!/bin/sh

# Ждём БД
echo "Waiting for database..."
while ! nc -z db 3306; do
  sleep 1
done
echo "Database ready!"

# Запускаем PHP-FPM в фоне
php-fpm -D

# Запускаем Nginx в foreground
nginx -g "daemon off;"
