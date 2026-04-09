FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    postgresql-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_pgsql pgsql intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

ARG UID=1000
ARG GID=1000
RUN addgroup -g ${GID} app && adduser -D -u ${UID} -G app app
USER app