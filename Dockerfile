
# Use the official PHP image
FROM php:8.2-apache
RUN apt-get update && \
  apt-get upgrade -y && \
  apt-get install -y git
# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Enable Apache
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy the project code into the container
COPY . /var/www/html

RUN composer self-update
RUN composer install
