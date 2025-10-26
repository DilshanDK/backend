FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libssl-dev \
    pkg-config

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Set working directory
WORKDIR /var/www/html

# Copy all files
COPY . .

# Download Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy Apache config
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 8000
EXPOSE 8000

# Start Apache
CMD ["apache2ctl", "-D", "FOREGROUND"]
