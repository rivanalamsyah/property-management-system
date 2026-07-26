#!/bin/bash
echo "Restarting Laravel Queue Workers..."
php artisan queue:restart
sudo supervisorctl restart kosan-worker:*
