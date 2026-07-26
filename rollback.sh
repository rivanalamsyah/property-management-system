#!/bin/bash
set -e

echo "Rolling back deployment..."
git reset --hard HEAD@{1}
php artisan optimize
sudo supervisorctl restart kosan-worker:*
echo "Rollback completed successfully."
