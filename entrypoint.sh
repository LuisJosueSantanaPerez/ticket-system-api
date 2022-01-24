#composer install
mv .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan optimize
