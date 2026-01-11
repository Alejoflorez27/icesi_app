FROM php:7.4.27-apache

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    software-properties-common \
    && apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    libfreetype6-dev \
    libicu-dev \
    libssl-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libedit-dev \
    libedit2 \
    libpq-dev \
    libxslt1-dev \
    libzip-dev \
    libonig-dev \
    apt-utils \
    gnupg \
    git \
    vim \
    wget \
    curl \
    lynx \
    psmisc \
    unzip \
    tar \
    cron \
    bash-completion \
    && apt-get clean

#Install Dependencies
RUN docker-php-ext-configure \
    gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/; \
    docker-php-ext-install \
    opcache \
    gd \
    bcmath \
    intl \
    mbstring \
    soap \
    xsl \
    zip \
    pdo_mysql

RUN mkdir -p /var/www/html/public

RUN chmod 777 -R /var/www \
    && chown -R www-data:www-data /var/www \
    && usermod -u 1000 www-data \
    && chsh -s /bin/bash www-data

RUN a2enmod rewrite
RUN a2enmod headers
RUN a2enmod ssl
RUN service apache2 restart

RUN ln -sf /dev/stdout /var/log/apache2/access.log \
    && ln -sf /dev/stderr /var/log/apache2/error.log

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    libzip-dev \
    libexif-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd exif

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Instalar Ghostscript
RUN apt-get update && \
    apt-get install -y ghostscript && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*



WORKDIR /var/www/html/public