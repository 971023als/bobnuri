FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable mysqli pdo_mysql \
    && a2enmod rewrite \
    && echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

COPY . /var/www/html/

RUN rm -f /var/www/html/php.ini \
          /var/www/html/php.ini-development \
          /var/www/html/php.ini-production \
    && chown -R www-data:www-data /var/www/html/

EXPOSE 80
