FROM php:8.3-fpm-alpine AS php-base

RUN apk add --no-cache     bash     git     icu-dev     libpng-dev     libzip-dev     oniguruma-dev     zip     unzip     $PHPIZE_DEPS     && docker-php-ext-install bcmath gd intl mbstring pdo_mysql zip     && apk del $PHPIZE_DEPS

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-empleo-lerma.ini

WORKDIR /var/www/html

FROM php-base AS development

CMD ["php-fpm"]

FROM node:20-alpine AS frontend-build

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build

FROM php-base AS production

ENV APP_ENV=production
ENV APP_DEBUG=false

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

COPY . .
COPY --from=frontend-build /app/public/build ./public/build

RUN composer dump-autoload --optimize \
    && php artisan package:discover --ansi \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

CMD ["php-fpm"]

FROM nginx:1.27-alpine AS nginx-production

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY public /var/www/html/public
COPY --from=frontend-build /app/public/build /var/www/html/public/build
