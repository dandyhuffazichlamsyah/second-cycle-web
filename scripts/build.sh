#!/usr/bin/env bash
set -e

echo "🔧 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "📦 Installing Node dependencies..."
npm ci

echo "🏗️ Building frontend assets..."
npm run build

echo "🔑 Generating application key if not set..."
php artisan key:generate --force || true

echo "🔗 Creating storage link..."
php artisan storage:link || true

echo "🗄️ Running database migrations..."
php artisan migrate --force

echo "🧹 Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build completed successfully!"
