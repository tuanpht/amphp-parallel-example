FROM php:7.1-cli

RUN apt-get update && apt-get -y --no-install-recommends install vim unzip \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && rm -rf /var/lib/apt/lists/*
