# Use a lighter PHP Apache image
FROM php:8.2-apache

# Install extensions early to take advantage of layer caching
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

# Enable .htaccess override
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy only required files first (for caching)
# COPY composer.json composer.lock /var/www/html/

# Run composer early if you use it (for dependency layer caching)
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
#     && composer install


# Now copy the rest of the app
COPY . /var/www/html

# Set minimal permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

EXPOSE 80
CMD ["apache2-foreground"]
