#!/bin/bash
set -e

# Create .env if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Create SQLite database file
touch /var/www/html/database/database.sqlite
chmod 664 /var/www/html/database/database.sqlite

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Generate app key if not set
php artisan key:generate --force || true

# Create storage link
php artisan storage:link || true

# Run migrations with SQLite
php artisan migrate --force || true

# Seed database if empty
php artisan db:seed --force || true

# Cache config
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"
