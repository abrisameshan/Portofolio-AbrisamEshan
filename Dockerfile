# Multi-stage build for Laravel 11 + Vue 3 (Inertia) on Render.com
FROM php:8.3-cli-alpine

# Install system dependencies & PHP extensions
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

# Set working directory
WORKDIR /var/www

# Copy all project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install frontend dependencies and build assets
RUN npm install && npm run build

# Setup SQLite database and permissions
RUN mkdir -p database storage bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 777 storage bootstrap/cache database

# Create startup script that handles dynamic $PORT from Render
RUN echo '#!/bin/bash' > /start.sh \
    && echo 'php artisan migrate --force' >> /start.sh \
    && echo 'php artisan config:cache' >> /start.sh \
    && echo 'php artisan route:cache' >> /start.sh \
    && echo 'php artisan view:cache' >> /start.sh \
    && echo 'exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}' >> /start.sh \
    && chmod +x /start.sh

# Render sets PORT dynamically (default 10000)
EXPOSE 10000

CMD ["/start.sh"]
