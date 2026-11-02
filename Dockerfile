FROM php:8.3-cli-alpine

# Install system dependencies & PHP extensions (including PDO SQLite)
RUN apk add --no-cache \
    bash \
    curl \
    git \
    nodejs \
    npm \
    sqlite \
    sqlite-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_sqlite pcntl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy all project files
COPY . .

# Ensure .env exists for build step
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Install dependencies and build assets
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

# Prepare database and write permissions
RUN mkdir -p database storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 777 storage bootstrap/cache database

# Self-healing startup script
RUN printf '%s\n' \
    '#!/bin/sh' \
    'cd /var/www' \
    'if [ ! -f .env ]; then cp .env.example .env; fi' \
    'if ! grep -q "APP_KEY=base64:" .env; then php artisan key:generate --force; fi' \
    'mkdir -p database storage/logs storage/framework/sessions storage/framework/views storage/framework/cache bootstrap/cache' \
    'touch database/database.sqlite' \
    'chmod -R 777 storage bootstrap/cache database' \
    'php artisan migrate --force' \
    'php artisan config:clear' \
    'php artisan route:clear' \
    'php artisan view:clear' \
    'echo "=== Antigravity Laravel Server Started on port ${PORT:-10000} ==="' \
    'exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}' \
    > /start.sh && chmod +x /start.sh

EXPOSE 10000

CMD ["/start.sh"]
