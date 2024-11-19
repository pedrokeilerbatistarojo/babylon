#!/bin/bash

export COMPOSER_ALLOW_SUPERUSER=1
composer install

# JWT
#php artisan key:generate
#php artisan jwt:secret -f

# Clear caches
# Flush the application cache
php artisan cache:clear
# Remove the route cache file
php artisan route:clear
# Remove the configuration cache file
php artisan config:clear
# Remove the compiled class file
php artisan clear-compiled  
# Remove the cached bootstrap files
php artisan optimize:clear
# Clear all compiled view files
php artisan view:clear

#Telescope
#php artisan telescope:install

# Database setup
php artisan migrate
#php artisan migrate:fresh
#php artisan db:seed

# Classmap
composer dump-autoload
#php artisan optimize

#Telescope
#php artisan telescope:publish

# Run services
#php artisan queue:work &
#php artisan serve --port=8000

echo "" > storage/logs/emergency.log
echo "" > storage/logs/laravel.log
echo "" > storage/logs/http-request.log
echo "" > storage/logs/query.log
echo "" > storage/logs/socket-server.log
echo "" > storage/logs/worker.log
echo "" > storage/logs/http-request.log

echo "
[global]
; error_log = /proc/self/fd/2
error_log = /tmp/fpm-error.log

; https://github.com/docker-library/php/pull/725#issuecomment-443540114
log_limit = 8192

[www]
; php-fpm closes STDOUT on startup, so sending logs to /proc/self/fd/1 does not work.
; https://bugs.php.net/bug.php?id=73886
; access.log = /proc/self/fd/2
access.log = /tmp/fpm-access.log

clear_env = no

; Ensure worker stdout and stderr are sent to the main error log.
catch_workers_output = yes
decorate_workers_output = no
" > /usr/local/etc/php-fpm.d/docker.conf

chown -R www-data:www-data -R /var/www
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo #########################################
echo ############# Run supervisord ###########
echo #########################################
supervisord -n -c /etc/supervisor/supervisord.conf

