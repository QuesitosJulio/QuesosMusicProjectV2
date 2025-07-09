FROM php:8.2-apache

# Instala la extensión mysqli
RUN docker-php-ext-install mysqli

# Copia tus archivos al directorio público de Apache
COPY . /var/www/html/

# Da permisos si es necesario
RUN chown -R www-data:www-data /var/www/html
