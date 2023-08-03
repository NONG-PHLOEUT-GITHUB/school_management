# Use the official PHP 8 image as the base image
FROM php:8.1.6-cli

# Set the working directory inside the container
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
  libzip-dev \
  zip \
  unzip

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo_mysql bcmath zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Laravel project files to the container
COPY . .

# Install Laravel dependencies
# RUN composer update
RUN composer install --ignore-platform-req=ext-gd

# Run migrations and seed the database
# RUN php artisan migrate && php artisan db:seed

# Generate application key
RUN php artisan key:generate

# Expose port 8000 (or any other desired port)
EXPOSE 8000

# Set the entrypoint command
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
