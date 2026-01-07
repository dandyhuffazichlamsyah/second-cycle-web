#!/bin/bash
set -e

# Create .env if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate app key if not set
php artisan key:generate --force || true

# Create storage link
php artisan storage:link || true

# Run migrations
php artisan migrate --force || true

# Cache config
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"
