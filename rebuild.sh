#!/bin/bash

docker compose down -v
docker system prune -f 
docker compose build --no-cache
docker compose up -d    

docker compose exec users_deep_app php artisan storage:link 
docker compose exec -u root users_deep_app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
docker compose exec users_deep_app chmod -R 775 storage
docker compose exec users_deep_app chmod -R 775 bootstrap/cache
docker compose exec users_deep_app php artisan migrate 
docker compose exec users_deep_app php artisan db:seed --class=UserSeeder
