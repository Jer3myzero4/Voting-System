# Use official PHP 8.2 with Apache
FROM php:8.2-apache

# -------------------------------
# Install system dependencies & PHP extensions
# -------------------------------
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql

# -------------------------------
# Enable Apache mod_rewrite
# -------------------------------
RUN a2enmod rewrite

# Allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# -------------------------------
# Copy application files including .env
# -------------------------------
COPY . /var/www/html/

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod 644 /var/www/html/.env

# -------------------------------
# Expose port 80 for Apache
# -------------------------------
EXPOSE 80

# -------------------------------
# Start Apache in the foreground
# -------------------------------
CMD ["apache2-foreground"]
