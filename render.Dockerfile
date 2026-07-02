FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends libjpeg62-turbo-dev libpng-dev libwebp-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install pdo pdo_mysql gd \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . .

ENV APP_DEBUG=false
ENV UPLOAD_STORAGE=database

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-10000} -t public public/router.php"]