#!/bin/sh
set -e

# Ensure writable storage for sessions/cache/logs (Render disk is mounted at runtime)
mkdir -p /var/www/storage \
    /var/www/storage/framework/views \
    /var/www/storage/framework/cache \
    /var/www/storage/framework/sessions \
    /var/www/storage/logs \
    /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

exec "$@"
