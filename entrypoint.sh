#!/bin/sh
set -e

cd /app

if [ ! -f .env ]; then
  cp .env.example .env
fi

mkdir -p database
touch database/database.sqlite

php artisan key:generate --force
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan migrate --force --seed

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8090}"
