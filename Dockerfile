FROM dunglas/frankenphp

RUN apt-get update && apt-get install -y \
        git unzip libzip-dev libpq-dev libonig-dev libxml2-dev libcap2-bin \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring zip bcmath xml \
    && rm -rf /var/lib/apt/lists/*

# FrankenPHP's binary ships with cap_net_bind_service (to allow binding low ports as
# non-root). Render's sandboxed runtime blocks executing binaries with that capability
# set, causing "Operation not permitted". We bind to a high port (10000+) so we don't
# need the capability at all — strip it.
RUN setcap -r "$(which frankenphp)" || true

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && mkdir -p storage/framework/{cache,sessions,testing,views} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan config:clear \
    && php artisan migrate --force \
    && php artisan config:cache \
    && frankenphp php-server --listen 0.0.0.0:${PORT:-10000} --root public
