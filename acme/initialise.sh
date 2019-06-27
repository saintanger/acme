#!/usr/bin/env bash

if [ ! -f ".env" ]; then

    composer install
    composer dump-autoload -o
    touch database/database.sqlite
    php artisan migrate --seed

fi

php artisan serve