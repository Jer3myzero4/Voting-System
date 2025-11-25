# Use official PHP 8.2 Apache image
FROM php:8.2-apache

# -------------------------
# Install PHP extensions
# -------------------------
RUN docker-php-ext-install pdo pdo_mysql

# -------------------------
# Enable Apache modules
# -------------------------
RUN a2enmod rewrite headers

# -------------------------
# Allow .htaccess overrides
# -------------------------
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# -------------------------
# Set ServerName to suppress AH00558 warning
# -------------------------
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# -------------------------
# Copy app files
# -------------------------
COPY . /var/www/html/

# -------------------------
# Fix permissions
# -------------------------
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# -------------------------
# Expose port 80
# -------------------------
EXPOSE 80

# -------------------------
# Start Apache in foreground
# -------------------------
CMD ["apache2-foreground"]
