FROM php:8.2-fpm-alpine

WORKDIR /app

RUN apk update && apk add --no-cache \
    openssl \
    oniguruma-dev \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring

RUN curl -sS https://getcomposer.org/installer | php; \
mv composer.phar /usr/local/bin/composer;

COPY init.sh /init.sh

RUN chmod +x /init.sh

CMD ["/init.sh"];