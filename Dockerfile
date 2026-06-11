# Menggunakan base image PHP 8.2 dengan Apache
FROM php:8.3-apache



# Install ekstensi sistem dan PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Aktifkan mod_rewrite Apache (wajib untuk routing Laravel)
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Pindah lokasi kerja ke folder web root
WORKDIR /var/www/html

# Copy SELURUH kode project Anda ke dalam Docker Image
COPY . /var/www/html

# Install dependencies Laravel (tanpa package dev)
RUN composer install --no-dev --optimize-autoloader

# Buat symlink otomatis untuk folder gambar/storage
RUN php artisan storage:link

# Atur permission (hak akses) untuk folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chown -h www-data:www-data /var/www/html/public/storage

# Ubah DocumentRoot Apache agar mengarah ke folder /public Laravel
RUN sed -i -e 's/html/html\/public/g' /etc/apache2/sites-available/000-default.conf

# Buka port 80
EXPOSE 80
