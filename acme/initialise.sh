#!/usr/bin/env bash

if [ ! -f ".env" ]; then

    composer install
    composer dump-autoload -o
    cp .env.example .env
    php artisan key:generate
    touch database/database.sqlite
    php artisan migrate --seed -n

fi

php artisan serve