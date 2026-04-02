#!/bin/sh

until php artisan db:show > /dev/null 2>&1; do
    echo "Adatbázis még nem elérhető, újrapróbálás 3 másodperc múlva..."
    sleep 3
done

php artisan migrate --force

php artisan db:seed --force

exec "$@"