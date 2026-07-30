#!/usr/bin/env sh

set -e

echo ""
echo "Running database migrations..."

php bin/console doctrine:migrations:migrate \
    --no-interaction \
    --allow-no-migration

echo ""
echo "Application is ready."

exec php-fpm
