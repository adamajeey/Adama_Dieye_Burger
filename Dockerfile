FROM php:8.2-fpm

# Arguments defined in docker-compose.yml with default values
ARG user=laraveluser
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    npm \
    nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install composer dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader --no-scripts

# Copy the rest of the application
COPY . .

# Copier env.docker en tant que .env au lieu de .env.example
COPY env.docker .env

# Generate application key
RUN php artisan key:generate

# Set permissions
RUN chown -R $user:$user /var/www
RUN chmod -R 755 /var/www/storage

# Switch to non-root user
USER $user

EXPOSE 9000
CMD ["php-fpm"]
