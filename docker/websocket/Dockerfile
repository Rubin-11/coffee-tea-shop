# Используем базовый образ php:8.4-cli-alpine
FROM php:8.4-cli-alpine

# Устанавливаем необходимые зависимости и расширения для работы с Redis
RUN apk add --no-cache autoconf g++ make \
    && pecl install redis \
    && docker-php-ext-enable redis

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Указываем рабочую директорию
WORKDIR /var/www/html

