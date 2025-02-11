# Use PHP 8.1 with Apache
FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libmagickwand-dev \
    git \
    unzip \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install zip \
    && pecl install imagick \
    && docker-php-ext-enable imagick

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set composer environment variables
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

# Update dependencies to be compatible with PHP 8.1
RUN composer update --no-dev --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Verify src directory structure and file case
RUN ls -la /var/www/html/src/Utils && \
    echo "File contents:" && \
    cat /var/www/html/src/Utils/Utils.php

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configure Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Create stats.json with proper permissions if it doesn't exist
RUN touch stats.json && \
    chown www-data:www-data stats.json && \
    chmod 664 stats.json

# Add debug information
RUN echo "<?php phpinfo(); ?>" > /var/www/html/info.php

# Expose port 80
EXPOSE 80