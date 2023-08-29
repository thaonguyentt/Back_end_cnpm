FROM php:8.2-bullseye
RUN docker-php-ext-install pdo_mysql \
     && docker-php-ext-enable pdo_mysql