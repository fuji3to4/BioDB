FROM php:8.3.20-apache-bookworm

ENV TZ=Asia/Tokyo

COPY php.ini /usr/local/etc/php/
COPY 000-default.conf /etc/apache2/sites-available/

RUN apt-get update \
    && apt-get install -y libonig-dev \
    && docker-php-ext-install pdo_mysql mysqli mbstring

RUN a2enmod dir


WORKDIR /html
RUN rm -rf /var/www/html
RUN ln -s /html /var/www/html 


