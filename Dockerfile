FROM php:8.3-apache

RUN a2enmod rewrite \
    && sed -ri 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf \
    && printf '%s\n' \
        '<Directory /var/www/html/public>' \
        '    AllowOverride All' \
        '    Require all granted' \
        '</Directory>' \
        > /etc/apache2/conf-available/app-public.conf \
    && a2enconf app-public

WORKDIR /var/www/html
COPY . /var/www/html
COPY docker-entrypoint-app.sh /usr/local/bin/docker-entrypoint-app.sh

RUN chown -R www-data:www-data /var/www/html/db

RUN chmod +x /usr/local/bin/docker-entrypoint-app.sh

ENTRYPOINT ["docker-entrypoint-app.sh"]
CMD ["apache2-foreground"]
