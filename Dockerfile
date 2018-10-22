FROM php:7.2-fpm-alpine3.8

LABEL maintainer="gbmcarlos@gmail.com"

## SYSTEM DEPENDENCIES
### vim and bash are utilities, so that we can work inside the container
### apache2-utils is necessary to use htpasswd to encrypt the password for basic auth
### $PHPIZE_DEPS contains the dependencies to use phpize, which is required to install with pecl
### supervisor, nginx and node+npm are part of the stack
### gettext is necessary to replace environment variables in the nginx config file at run time, for the basic auth
RUN     apk update \
    &&  apk add \
            bash vim \
            gettext apache2-utils \
            libjpeg-turbo-dev libpng-dev \
            supervisor \
            nginx=1.14.0-r1 \
            $PHPIZE_DEPS

## PHP EXTENSIONS
### Install xdebug but don't enable it, it will be enabled at run time if needed
RUN     set -ex \
    &&  pecl install \
            xdebug-2.6.1 \
    &&  docker-php-ext-install \
            pdo_mysql \
            opcache \
            gd \
    &&  docker-php-ext-configure \
            gd --with-jpeg-dir=/usr

WORKDIR /var/www

## SCRIPTS
### Make sure all scripts have execution permissions
COPY ./deploy/scripts/* ./
RUN chmod +x ./*.sh

## COMPOSER
### Install composer by copying the binary from composer's official image (compressed multi-stage)
### So far, we are just going to install the dependencies, so no need to dump the autoloader yet
### At the end, remove the root's composer folder that was used to install and use prestissimo
COPY --from=composer:1.7.2 /usr/bin/composer /usr/bin/composer
COPY ./composer.* ./
RUN     composer global require hirak/prestissimo:0.3.8 \
    &&  composer install -v --no-autoloader --no-suggest --no-dev \
    &&  rm -rf /root/.composer

## SOURCE CODE
COPY ./src ./src

## PERMISSIONS
### create www user and group for nginx
### set the permission for the temp folder of nginx
### set permission for the storage folder
RUN     adduser -D -g 'www' www \
    &&  chown -R www:www /var/tmp/nginx

## COMPOSER AUTOLOADER
### Now that we've copied the source code, dump the autoloader
### By default, optimize the autoloader
RUN composer dump-autoload -v --optimize --classmap-authoritative;

## CONFIGURATION FILES
### php, php-fpm, nginx and supervisor config files
COPY ./deploy/config/php.ini /usr/local/etc/php/php.ini
COPY ./deploy/config/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ./deploy/config/nginx.conf /etc/nginx/nginx.conf
COPY ./deploy/config/supervisor.conf /etc/supervisor.conf

EXPOSE 80

CMD ["./entrypoint.sh"]