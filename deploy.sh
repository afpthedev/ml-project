#!/bin/bash

# Make sure this file has executable permissions, run `chmod +x deploy.sh` to ensure it does
COPY deploy.sh /app/deploy.sh
RUN chmod +x /app/deploy.sh

# Clear cache
php artisan optimize:clear

# Cache the various components of the Laravel application
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache


php artisan migrate
# Run any database migrations
php artisan migrate --force

php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT


