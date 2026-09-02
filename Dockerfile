# Gunakan image dasar PHP versi 8.3 dengan FPM
FROM php:8.3-fpm

# Set working directory (lokasi default di dalam container)
WORKDIR /var/www/html

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# Bersihkan cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install ekstensi PHP inti untuk Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Ambil Composer langsung dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atasi error "dubious ownership" agar Composer bisa menjalankan Git
RUN git config --global --add safe.directory /var/www/html
