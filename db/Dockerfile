FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (optional, good practice)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html
