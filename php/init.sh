cd /app;
composer install;
until php artisan db:monitor | grep -q "OK"; do
    echo "Waiting for database...";
    sleep 5;
done

php artisan migrate;
php artisan db:seed;
php artisan serve --host=0.0.0.0 --port=80;