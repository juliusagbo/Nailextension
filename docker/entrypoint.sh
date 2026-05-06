#!/usr/bin/env sh
set -e

cd /var/www/html

if [ -n "$APP_KEY" ]; then
  sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
fi

if [ -n "$APP_URL" ]; then
  sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|" .env
fi

if [ -n "$APP_ENV" ]; then
  sed -i "s|^APP_ENV=.*|APP_ENV=${APP_ENV}|" .env
fi

if [ -n "$APP_DEBUG" ]; then
  sed -i "s|^APP_DEBUG=.*|APP_DEBUG=${APP_DEBUG}|" .env
fi

if [ -n "$DB_CONNECTION" ]; then
  sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=${DB_CONNECTION}|" .env
fi

if [ -n "$DB_DATABASE" ]; then
  sed -i "s|^DB_DATABASE=.*|DB_DATABASE=${DB_DATABASE}|" .env
fi

touch database/database.sqlite
php artisan key:generate --force >/dev/null 2>&1 || true
php artisan migrate --force || true
php artisan config:cache || true

exec apache2-foreground
