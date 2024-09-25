# Use an official PHP image
FROM php:8.2-apache

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory to /var/www/html
WORKDIR /var/www/html

# Copy the application code into the container
COPY . /var/www/html

# Ensure that Apache can read your public files
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
