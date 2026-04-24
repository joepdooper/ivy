FROM php:8.4-apache

# System dependencies
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

# PHP extensions
RUN docker-php-ext-configure gd \
        --with-jpeg \
        --with-webp \
        --with-freetype \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
        gd

# Apache modules
RUN a2enmod rewrite headers deflate expires

# Composer (stable, pinned version, correct PATH)
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer \
    && composer --version

# Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www

EXPOSE 80

CMD ["apache2-foreground"]