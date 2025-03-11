# Используем базовый образ php:8.4-fpm-alpine
FROM php:8.4-fpm-alpine

# Устанавливаем необходимые зависимости и расширения для работы с PostgreSQL
RUN apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Указываем рабочую директорию
WORKDIR /var/www/html

