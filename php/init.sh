cd /app;

cp .env.example .env;
echo "MYSQL_HOST=$MYSQL_HOST" >> .env;
echo "MYSQL_DBNAME=$MYSQL_DBNAME" >> .env;
echo "MYSQL_USER=$MYSQL_USER" >> .env;
echo "MYSQL_PASSWORD=$MYSQL_PASSWORD" >> .env;

composer install;
until php artisan db:monitor | grep -q "OK"; do
    echo "Waiting for database...";
    sleep 5;
done

php artisan migrate;
php artisan serve --host=0.0.0.0 --port=80;