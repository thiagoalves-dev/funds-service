FROM php:8.2-fpm-alpine

#Install postgres dependencies
RUN set -ex && apk --no-cache add postgresql-dev

#Install application dependencies
RUN apk add --no-cache
RUN docker-php-ext-install mysqli pdo_mysql pdo_pgsql

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS && \
    pecl update-channels && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    apk del $PHPIZE_DEPS

RUN apk --no-cache add bash openrc

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ENV COMPOSER_MEMORY_LIMIT=-1

#RUN apk add --update nodejs npm
#
#RUN npm install -g yarn

# Create dev user
USER root
RUN addgroup -S dev &&\
    adduser -u 1000 -G dev -S dev

# Switch to use a non-root user from here on
USER dev

# Setup document root
RUN mkdir -p /var/www/html/funds-service

# Set root dir
WORKDIR /var/www/html/funds-service
