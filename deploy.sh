#!/bin/bash
# DVT Bank CRM - Plesk Git Deployment Script
# Target: dvt.portegu.com @ 213.159.6.158

set -e

echo "🚀 Deployment started at $(date)..."

# 1. Composer bağımlılıklarını optimize et
composer install --no-dev --optimize-autoloader --no-interaction

# 2. Veritabanı migration'larını çalıştır
php artisan migrate --force --no-interaction

# 3. Cache'leri temizle ve optimize et
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Storage sembolik linkini oluştur (gerekliyse)
php artisan storage:link || true

echo "✅ Deployment completed successfully at $(date)!"
