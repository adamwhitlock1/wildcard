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

# Copy the entire application
COPY . .

# Create necessary directories
RUN mkdir -p /var/www/html/logs

# Create entrypoint script
RUN echo '#!/bin/bash\n\
if [ ! -f /var/www/html/stats.json ]; then\n\
    echo "{\"count\": 0}" > /var/www/html/stats.json\n\
fi\n\
touch /var/www/html/logs/php_error.log\n\
chown -R www-data:www-data /var/www/html\n\
chmod -R 755 /var/www/html\n\
chmod 664 /var/www/html/stats.json\n\
chmod 664 /var/www/html/logs/php_error.log\n\
apache2-foreground' > /usr/local/bin/docker-entrypoint.sh

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Configure Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Expose port 80
EXPOSE 80

# Set the entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]