# Temel imajı kullan
FROM php:8.2-fpm

# Çalışma dizini
WORKDIR /app

# Gerekli bağımlılıkları yükle
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip pdo_mysql

# Composer'ı yükle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Proje dosyalarını kopyala
COPY . /app

# deploy.sh dosyasına çalıştırma izni ver
RUN chmod +x /app/deploy.sh

# Gerekli bağımlılıkları yükle
RUN composer install --optimize-autoloader --no-dev

# İzinleri ayarla
RUN chown -R www-data:www-data /app \
    && chmod -R 775 storage bootstrap/cache

# Portu aç
EXPOSE 8000

# Uygulamayı başlat
CMD ["/app/deploy.sh"]
