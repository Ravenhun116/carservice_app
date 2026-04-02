# CarService App

Laravel 13 alapú szervizelőrendszer Docker környezetben.

---

## Rendszerkövetelmények

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) telepítve és elindítva

---

## Technológiai stack és verziók

| Technológia | Verzió |
|-------------|--------|
| PHP | 8.4-fpm |
| Laravel | 13 |
| MySQL | 8.4 |
| Nginx | alpine (legújabb) |
| Node.js | alpine (legújabb) |
| Composer | legújabb |

### PHP extensions

- pdo_mysql
- mbstring
- exif
- pcntl
- bcmath
- gd
- zip
- opcache
- intl

---

## Docker szolgáltatások

| Service | Container neve | Port |
|---------|---------------|------|
| PHP-FPM (Laravel) | laravel_app | 9000 |
| Nginx | laravel_nginx | 8080 |
| MySQL | laravel_mysql | 3306 |
| Vite dev server | laravel_vite | 5173 |

---

## Konfiguráció

### PHP (docker/php/local.ini)

```ini
upload_max_filesize = 40M
post_max_size = 40M
memory_limit = 256M
max_execution_time = 600
```

### MySQL

- Secure transport kikapcsolva (--require-secure-transport=OFF)
- Adatok perzisztens volume-ban tárolva (mysql_data)

### .env adatbázis beállítások

```dotenv
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

---

## Telepítés és indítás

### 1. Laravel telepítése

A projekt szülőmappájából:

```bash
docker run --rm -v $(pwd):/app composer create-project laravel/laravel carservice_app
```

### 2. Docker fájlok elhelyezése

```
carservice_app/
├── Dockerfile
├── docker-compose.yml
└── docker/
    ├── nginx/
    │   └── default.conf
    ├── php/
    │   └── local.ini
    └── entrypoint.sh
```

### 3. Seed adatok elhelyezése

```
database/
└── data/
    ├── clients.json
    ├── cars.json
    └── services.json
```

### 4. .env beállítása

```dotenv
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### 5. Docker indítása

```bash
cd carservice_app
docker-compose up -d --build
```

Az indítás során az entrypoint script automatikusan:
- Megvárja hogy a MySQL elinduljon
- Lefuttatja a migrációkat
- Betölti a seed adatokat (csak ha a táblák üresek)


## Az alkalmazás elérése

| Szolgáltatás | URL |
|-------------|-----|
| Laravel app | http://localhost:8080 |
| Vite dev server | http://localhost:5173 |
| MySQL | 127.0.0.1:3306 |

---

## Hasznos parancsok

| Parancs | Leírás |
|---------|--------|
| docker-compose up -d --build | Containerek indítása és buildelése |
| docker-compose down | Containerek leállítása |
| docker-compose down -v | Containerek leállítása + adatok törlése |
| docker-compose logs app | App logok megtekintése |
| docker-compose exec app php artisan migrate | Migráció futtatása |
| docker-compose exec app php artisan db:seed | Seed adatok betöltése |
| docker-compose exec app php artisan route:clear | Route cache törlése |

---

## Adatbázis kapcsolat (pl. DBeaver)

| Beállítás | Érték |
|-----------|-------|
| Host | 127.0.0.1 |
| Port | 3306 |
| Database | laravel |
| Username | laravel |
| Password | secret |
| SSL | disabled |
| Allow Public Key Retrieval | true |
