FROM php:8.2-fpm-alpine

WORKDIR /app

RUN apk update && apk add --no-cache \
    openssl \
    oniguruma-dev \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring

RUN curl -sS https://getcomposer.org/installer | php; \
mv composer.phar /usr/local/bin/composer;

COPY initlaravel.sh /initlaravel.sh

RUN chmod +x /initlaravel.sh

CMD ["/initlaravel.sh"];