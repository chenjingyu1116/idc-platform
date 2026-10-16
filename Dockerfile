FROM php:8.4-fpm-alpine

# 系统依赖
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    icu-dev \
    libzip-dev \
    sqlite-dev \
    mysql-client

# PHP 扩展
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_sqlite \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 工作目录
WORKDIR /var/www/html

# 复制项目
COPY . .

# 安装依赖（生产模式）
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 权限
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# 配置
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
