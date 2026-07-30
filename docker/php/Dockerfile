FROM php:8.4-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo_mysql \
        bcmath \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN git config --global --add safe.directory /var/www/html

RUN composer install

CMD ["php-fpm"]
