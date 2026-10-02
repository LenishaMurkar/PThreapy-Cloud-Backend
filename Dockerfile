FROM php:8.2-apache

# Install cURL extension required for Supabase REST API
RUN apt-get update \
    && apt-get install -y libcurl4-openssl-dev \
    && docker-php-ext-install curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy the PHP backend into Apache's web directory
COPY . /var/www/html/

# Enable Apache rewrite module
RUN a2enmod rewrite

# Render uses the PORT environment variable
ENV PORT=10000

# Configure Apache to listen on Render's port
RUN sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf \
    && sed -i 's/:80>/:10000>/' /etc/apache2/sites-available/000-default.conf

EXPOSE 10000

CMD ["apache2-foreground"]