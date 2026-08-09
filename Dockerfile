FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
        git unzip libzip-dev libpq-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring zip bcmath xml \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && mkdir -p storage/framework/{cache,sessions,testing,views} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD php artisan config:clear \
    && php artisan migrate --force \
    && php artisan config:cache \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
