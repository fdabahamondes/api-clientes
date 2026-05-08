FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git unzip zip \
    libpng-dev libonig-dev libxml2-dev

RUN docker-php-ext-install pdo pdo_mysql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install

EXPOSE 9000

CMD ["php-fpm"]