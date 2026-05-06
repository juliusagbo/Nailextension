#!/usr/bin/env sh
set -e

cd /var/www/html

set_env() {
  key="$1"
  value="$2"
  if grep -q "^${key}=" .env; then
    sed -i "s|^${key}=.*|${key}=${value}|" .env
  else
    echo "${key}=${value}" >> .env
  fi
}

[ -n "$APP_URL" ] && set_env "APP_URL" "$APP_URL"
[ -n "$APP_ENV" ] && set_env "APP_ENV" "$APP_ENV"
[ -n "$APP_DEBUG" ] && set_env "APP_DEBUG" "$APP_DEBUG"
[ -n "$DB_CONNECTION" ] && set_env "DB_CONNECTION" "$DB_CONNECTION"
[ -n "$DB_DATABASE" ] && set_env "DB_DATABASE" "$DB_DATABASE"

touch database/database.sqlite
if [ -n "$APP_KEY" ]; then
  set_env "APP_KEY" "$APP_KEY"
elif grep -q "^APP_KEY=$" .env; then
  php artisan key:generate --force
fi

php artisan optimize:clear
php artisan migrate --force --no-interaction
php artisan config:cache

exec apache2-foreground
