# استخدام PHP 8.3 FPM base image
FROM php:8.3-fpm

ENV DEBIAN_FRONTEND=noninteractive

# تثبيت الحزم الضرورية
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    postgresql-client \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    zip \
 && docker-php-ext-install intl pdo pdo_pgsql mbstring zip \
 && docker-php-ext-enable intl zip \
 && rm -rf /var/lib/apt/lists/* \
 && apt-get clean

# تثبيت Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# مجلد العمل
WORKDIR /var/www

# نسخ ملفات المشروع
COPY . /var/www

# صلاحيات الملفات
RUN chown -R www-data:www-data /var/www

# Fix: Git safe directory
RUN git config --global --add safe.directory /var/www

# تثبيت dependencies Laravel
RUN COMPOSER_MEMORY_LIMIT=-1 COMPOSER_PROCESS_TIMEOUT=2000 composer install --no-dev --optimize-autoloader

EXPOSE 9000
CMD ["php-fpm"]
