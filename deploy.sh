#!/bin/bash
set -e

echo "Deploying application..."
php artisan down

git pull origin main

composer install --no-dev --optimize-autoloader --no-interaction
npm install
npm run build

php artisan migrate --force
php artisan optimize

sudo supervisorctl restart kosan-worker:*

php artisan up
echo "Deployment finished successfully."
