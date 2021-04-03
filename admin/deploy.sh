#!/bin/bash
echo "Deploying application ..."

# Enter maintenance mode
(php artisan down) || true
    # Update codebase
    git pull && composer install
# Exit maintenance mode
php artisan up

echo "Application deployed!"
