FROM php:8.1-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html/

WORKDIR /var/www/html

RUN composer install --no-interaction

RUN rm README.md

EXPOSE 80

CMD ["apache2-foreground"]
