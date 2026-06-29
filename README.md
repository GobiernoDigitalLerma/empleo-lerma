# Empleo Lerma 2.0

Empleo Lerma 2.0 es la versión actualizada de la aplicación municipal de empleo de Lerma. Está construida en Laravel 12 con Blade, Bootstrap 5, MySQL, colas con driver `database` y notificaciones por correo.

Esta versión reemplaza funcionalmente al proyecto legacy `empleo-lerma`, pero no modifica el código anterior ni migra datos legacy.

## Ejecución Con Docker En Desarrollo

Usa esta opción cuando quieres levantar todo el ambiente local con contenedores: Laravel, MySQL, Vite, queue, scheduler y Mailpit.

```bash
cp .env.example .env
docker compose -f docker-compose.dev.yml up --build
docker compose -f docker-compose.dev.yml exec app composer install
docker compose -f docker-compose.dev.yml exec node npm install
docker compose -f docker-compose.dev.yml exec app php artisan key:generate
docker compose -f docker-compose.dev.yml exec app php artisan migrate:fresh --seed
```

URLs de desarrollo:

- Aplicación: http://localhost:8080
- Vite: http://localhost:5173
- Mailpit: http://localhost:8025

Comandos útiles:

```bash
docker compose -f docker-compose.dev.yml ps
docker compose -f docker-compose.dev.yml logs -f queue
docker compose -f docker-compose.dev.yml exec app php artisan queue:failed
docker compose -f docker-compose.dev.yml exec app php artisan queue:restart
```

## Ejecución Local Sin Docker

Usa esta opción si ya tienes instalado PHP, Composer, MySQL, Node.js y npm en tu equipo.

Requisitos:

- PHP 8.3
- Composer 2
- MySQL 8
- Node.js 20 LTS
- npm

Instalación:

```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed
```

Procesos de desarrollo:

```bash
php artisan serve
```

```bash
npm run dev
```

```bash
php artisan queue:work database --queue=default --tries=3 --timeout=90 --sleep=2
```

Opcional para scheduler:

```bash
php artisan schedule:work
```

En local puedes usar Mailpit si lo tienes instalado o configurar Gmail SMTP en `.env`.

## Ejecución Con Docker En Producción

Producción no usa Mailpit ni Vite dev server. El build genera assets con Vite dentro de la imagen y ejecuta Laravel con PHP-FPM, Nginx, MySQL, queue y scheduler.

Prepara variables:

```bash
cp .env.production.example .env
```

Configura al menos:

- `APP_KEY`
- `APP_URL`
- `DB_PASSWORD`
- `DB_ROOT_PASSWORD`
- `MAIL_HOST=smtp.gmail.com`
- `MAIL_PORT=587`
- `MAIL_USERNAME`
- `MAIL_PASSWORD`
- `MAIL_ENCRYPTION=tls`
- `MAIL_FROM_ADDRESS`

Levanta producción:

```bash
docker compose up -d --build
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --class=AdminSeeder --force
docker compose exec app php artisan db:seed --class=CatalogSeeder --force
```

Verifica servicios:

```bash
docker compose ps
docker compose logs -f queue
docker compose exec app php artisan queue:monitor database:100
docker compose exec app php artisan queue:failed
```

Después de un deploy o cambio de código:

```bash
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan optimize
docker compose exec app php artisan queue:restart
docker compose restart queue scheduler
```

## Usuario Inicial

El administrador de producción se crea con:

```bash
docker compose exec app php artisan db:seed --class=AdminSeeder --force
```

Antes de ejecutarlo configura estas variables en `.env`:

- `ADMIN_NAME`
- `ADMIN_EMAIL`
- `ADMIN_PASSWORD`

En producción `ADMIN_EMAIL` y `ADMIN_PASSWORD` son obligatorios. Si faltan, el seeder se detiene para evitar una cuenta insegura.

## Catálogos Iniciales

Los catálogos base de producción se crean con:

```bash
docker compose exec app php artisan db:seed --class=CatalogSeeder --force
```

Este comando carga valores iniciales para escolaridad, tipos de empleo, municipios, estados, idiomas, estados de empresa, estados de vacante, estados de postulación y fuentes de origen.

Para desarrollo puedes usar:

```bash
php artisan migrate:fresh --seed
```

Ese flujo sí carga datos demo para validar pantallas públicas y dashboards. No lo uses en producción si no quieres datos de prueba.

## Validación

```bash
php artisan test
npm run build
```

Con Docker de desarrollo:

```bash
docker compose -f docker-compose.dev.yml exec app php artisan test
docker compose -f docker-compose.dev.yml exec node npm run build
```
