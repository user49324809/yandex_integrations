FROM php:8.2-cli

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем проект
COPY . .

# Установка зависимостей Laravel
RUN composer install --no-dev --optimize-autoloader

# Генерация ключа (если нет)
RUN php artisan key:generate || true

# Открываем порт
EXPOSE 8080

# Запуск Laravel
CMD php artisan serve --host=0.0.0.0 --port=8080
RUN php artisan migrate --force
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear