FROM php:8.0-apache

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y libxml2-dev --no-install-recommends mediainfo && \
    docker-php-ext-install mysqli pdo pdo_mysql soap

WORKDIR /var/www/html

COPY ./index.php .
COPY ./php.ini /usr/local/etc/php/conf.d/init.ini
COPY ./.htaccess .

RUN a2enmod rewrite

EXPOSE 80