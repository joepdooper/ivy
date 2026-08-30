FROM php:8.5-apache

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
    ca-certificates \
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

# Install Composer (official installer)
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php \
    && php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer \
    && composer --version \
    && rm /tmp/composer-setup.php

# Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www

EXPOSE 80

CMD ["sh", "-c", "\
    chmod -R a+rwX \
        /var/www/vendor \
        /var/www/plugins \
        /var/www/templates \
        /var/www/cache/composer \
        /var/www/logs \
    && chmod a+rw \
        /var/www/composer.json \
        /var/www/composer.lock \
    && git config --system --add safe.directory /var/www \
    && git config --system --add safe.directory /var/ivy-cultivate \
    && git config --system --add safe.directory /var/ivy-roots \
    && git config --system --add safe.directory /var/ivy-sprout \
    && exec apache2-foreground \
"]