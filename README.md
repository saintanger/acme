**Acme shop**

**Requirements:**
PHP 7.1+, composer, php-sqlite

**Install:**

Install via composer: `cd acme && composer install && composer dump-autoload -o`

Create the migrations and seed data: `touch database/database.sqlite && php artisan migrate --seed`

Run artisan internal webserver: `php artisan serve`

Or

Just execute initialise.sh


**Usage:**
Visit localhost:8000 on your browser and you'll be able to add and remove products from the cart.

**Notes & Assumptions:**
File database and sessions used for ease of running without creating further services.
ShoppingRules are only for discounts and not surcharges
