FROM docker.io/php:8.4-apache

# Install system deps
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    git \
    unzip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd \
        --with-jpeg \
        --with-webp \
        --with-freetype \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
        gd

# Enable Apache modules
RUN a2enmod rewrite headers deflate expires

ENV APACHE_DOCUMENT_ROOT=/var/www/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www

EXPOSE 80

CMD ["apache2-foreground"]