# CarService App

Laravel alapú autószerviz nyilvántartó alkalmazás, Docker környezetben futtatva.

---

## Technológiai stack

| Komponens | Verzió |
|-----------|--------|
| PHP | 8.4-fpm |
| Laravel | 13.2.0 |
| MySQL | 8.4 |
| Nginx | alpine (latest) |
| Node.js | alpine (latest) |
| Composer | latest |

### Telepített PHP extension-ök

`pdo_mysql`, `mbstring`, `exif`, `pcntl`, `bcmath`, `gd`, `zip`, `opcache`, `intl`

---

## Docker szolgáltatások

| Service | Container neve | Port |
|---------|---------------|------|
| PHP-FPM (Laravel) | `laravel_app` | 9000 |
| Nginx | `laravel_nginx` | 8080 |
| MySQL | `laravel_mysql` | 3306 |
| Vite dev server | `laravel_vite` | 5173 |

---

## Előfeltételek

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) telepítve és futtatva
- Git

---

## Telepítés és indítás

### 1. Repó klónozása

```bash
git clone https://github.com/Ravenhun116/carservice_app.git
cd carservice_app
```

### 2. Környezeti konfiguráció

Másold le az `.env.example` fájlt `.env` névvel:

```bash
cp .env.example .env
```

Az `.env` fájlban az adatbázis beállítások:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

> **Fontos:** A `DB_HOST` értéke `mysql` legyen (a Docker service neve), nem `127.0.0.1`.

### 3. Docker containerek indítása

```bash
docker-compose up -d --build
```

Az első indításkor az `entrypoint.sh` script automatikusan elvégzi:
- megvárja, hogy a MySQL elinduljon
- lefuttatja a migrációkat (`php artisan migrate`)
- betölti a seed adatokat, ha a táblák üresek (`php artisan db:seed`)

### 4. Composer függőségek telepítése

```bash
docker-compose exec app composer install
```

### 5. APP_KEY generálása

```bash
docker-compose exec app php artisan key:generate
```

### 6. Frontend build

```bash
docker-compose exec app npm install
docker-compose exec app npm run build
```

### 7. Az alkalmazás elérése

| Felület | URL |
|---------|-----|
| Laravel alkalmazás | http://localhost:8080 |
| Vite dev server | http://localhost:5173 |
| MySQL (külső kliens) | 127.0.0.1:3306 |

---

## Adatbázis kapcsolat külső kliensből (pl. DBeaver, TablePlus)

| Beállítás | Érték |
|-----------|-------|
| Host | `127.0.0.1` |
| Port | `3306` |
| Database | `laravel` |
| Username | `laravel` |
| Password | `secret` |
| SSL | disabled |
| Allow Public Key Retrieval | true |

---

## PHP konfiguráció (`docker/php/local.ini`)

```ini
upload_max_filesize = 40M
post_max_size = 40M
memory_limit = 256M
max_execution_time = 600
```

---

## Hasznos parancsok

```bash
# Containerek indítása
docker-compose up -d --build

# Containerek leállítása
docker-compose down

# Containerek leállítása + adatok törlése
docker-compose down -v

# App logok megtekintése
docker-compose logs app

# Migráció futtatása
docker-compose exec app php artisan migrate

# Seed adatok betöltése
docker-compose exec app php artisan db:seed

# Route cache törlése
docker-compose exec app php artisan route:clear

# Artisan parancs futtatása általánosan
docker-compose exec app php artisan <parancs>
```

---

## Projektstruktúra (főbb mappák)

```
carservice_app/
├── app/                  # Laravel alkalmazás (Models, Controllers, stb.)
├── config/               # Laravel konfigurációs fájlok
├── database/
│   ├── migrations/       # Adatbázis migrációk
│   └── seeders/          # Seed adatok
├── docker/
│   ├── nginx/default.conf
│   ├── php/local.ini
│   └── entrypoint.sh
├── public/               # Webszerver gyökér
├── resources/            # Blade nézetek, CSS, JS
├── routes/               # Útvonaldefiníciók
├── .env.example          # Környezeti változók mintafájl
├── docker-compose.yml
└── Dockerfile
```
