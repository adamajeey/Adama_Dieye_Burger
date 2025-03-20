FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

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

# Copy application files
COPY . /var/www/

# Install dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader
# Commenté pour éviter l'erreur avec les fichiers frontend manquants
# RUN npm install && npm run build

# Generate application key
RUN php artisan key:generate

# Set permissions
RUN chown -R $user:$user /var/www
RUN chmod -R 755 /var/www/storage

# Switch to non-root user
USER $user

EXPOSE 9000
CMD ["php-fpm"]
