FROM php:8.0-fpm

RUN apt-get update \
    && apt-get install -y zlib1g-dev mariadb-client vim libzip-dev \
    && apt-get install -y  \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install zip pdo_mysql \
    && pecl install xdebug

RUN useradd -ms /bin/bash jill \
    && echo "jill:re3" | chpasswd
    
USER jill

# マルチステージビルドでcomposer
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
