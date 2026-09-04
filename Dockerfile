# ==========================================
# phpMyAdmin Production Dockerfile (PHP 8.3)
# Optimized for Coolify Deployment
# ==========================================

FROM php:8.3-apache

LABEL maintainer="Gregmar"
LABEL description="phpMyAdmin 5.2.1 on PHP 8.3 with dynamic .env configuration"

# Install system dependencies required for PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libbz2-dev \
    libonig-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Configure and install required PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo_mysql \
    mbstring \
    zip \
    gd \
    bz2 \
    opcache

# Configure PHP settings for phpMyAdmin (handles large database imports)
RUN { \
    echo 'upload_max_filesize = 512M'; \
    echo 'post_max_size = 512M'; \
    echo 'memory_limit = 512M'; \
    echo 'max_execution_time = 600'; \
    echo 'max_input_time = 600'; \
    echo 'max_input_vars = 10000'; \
    echo 'session.save_path = "/tmp"'; \
    echo 'opcache.enable = 1'; \
    echo 'opcache.memory_consumption = 128'; \
    echo 'opcache.interned_strings_buffer = 8'; \
    echo 'opcache.max_accelerated_files = 10000'; \
    echo 'opcache.revalidate_freq = 2'; \
} > "$PHP_INI_DIR/conf.d/phpmyadmin-custom.ini"

# Enable Apache modules
RUN a2enmod rewrite headers

# Configure Apache ServerName to suppress warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy application files to web root
COPY . /var/www/html

# Ensure tmp directory exists with write permissions for Apache
RUN mkdir -p /var/www/html/tmp/twig \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/tmp

# Expose standard HTTP port (Coolify defaults to port 80)
EXPOSE 80

# Apache runs in foreground
CMD ["apache2-foreground"]
