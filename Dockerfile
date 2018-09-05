FROM php:7.2-apache-stretch

LABEL maintainer="gbmcarlos@ekar.ae"

### System dependencies
#### git and zip are necessary to use composer
RUN     set -ex \
    &&  apt-get update \
    &&  apt-get upgrade -y \
    &&  apt-get -yq install \
            autoconf \
            git \
            zip \
            libjpeg-dev \
            libpng-dev \
    &&  rm -rf /var/lib/apt/lists/*

### PHP extensions
#### Install both opcache and xdebug regardles of the environment (regardless of the env vars), they will be enabled or disabled later
RUN     set -ex \
    &&  pecl install \
            xdebug-stable \
    &&  docker-php-ext-install \
            gd \
            opcache \
    &&  docker-php-ext-enable \
            xdebug \
    &&  docker-php-ext-configure \
            gd --with-jpeg-dir=/usr

### Configure PHP
#### https://secure.php.net/manual/en/opcache.installation.php#opcache.installation.recommended
#### If OPTIMIZE_PHP set the error reporting settings and the setting OPCache
#### If not OPTIMIZE_PHP, set the error reporting settings and delete the .ini config file for OPCache that was created by the docker-php-ext-install script
ARG OPTIMIZE_PHP=false
RUN if \
        [ $OPTIMIZE_PHP = "true" ] ; \
    then \
            echo '\
display_errors=Off\n\
display_startup_errors=Off\n\
error_reporting=E_ALL\n\
log_errors=On' >> /usr/local/etc/php/php.ini \
        &&  echo '\
opcache.memory_consumption=Off\n\
opcache.interned_strings_buffer=Off\n\
opcache.max_accelerated_files=Off\n\
opcache.revalidate_freq=Off\n\
opcache.fast_shutdown=Off\n\
opcache.enable_cli=On' >> /usr/local/etc/php/conf.d/opcache.ini; \
    else \
            echo '\
display_errors=STDOUT\n\
display_startup_errors=On\n\
error_reporting=E_ALL\n\
log_errors=On' >> /usr/local/etc/php/php.ini \
        &&  rm /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini; \
    fi

### Composer install
COPY ./composer.* /var/www/
RUN php /var/www/composer.phar install -v --working-dir=/var/www --no-autoloader --no-suggest --no-dev

### Apache2 configuration
RUN a2enmod rewrite
COPY deploy/scripts/000-default.conf /etc/apache2/sites-available/000-default.conf
ARG BASIC_AUTH_ENABLED=false
ENV BASIC_AUTH_ENABLED $BASIC_AUTH_ENABLED
ARG BASIC_AUTH_USER=''
ARG BASIC_AUTH_PASSWORD=''
RUN if \
        [ $BASIC_AUTH_ENABLED = "true" ] ; \
    then \
        htpasswd -cb -B -C 10 /etc/apache2/.htpasswd $BASIC_AUTH_USER $BASIC_AUTH_PASSWORD; \
    fi

### Source code
COPY ./src /var/www/src

WORKDIR /var/www

### Composer optimizie
ARG OPTIMIZE_COMPOSER=false
RUN if \
        [ $OPTIMIZE_COMPOSER = "true" ] ; \
    then \
        php /var/www/composer.phar dump-autoload -v --working-dir=/var/www --optimize --classmap-authoritative; \
    else \
        php /var/www/composer.phar dump-autoload -v --working-dir=/var/www; \
    fi

### XDebug support
#### If XDEBUG_ENABLED set the settings for Xdebug
#### If not XDEBUG_ENABLED, delete the .ini config file that was created by the docker-php-ext-enable script
ARG XDEBUG_ENABLED=false
ARG XDEBUG_REMOTE_HOST
ARG XDEBUG_REMOTE_PORT
ARG XDEBUG_IDE_KEY
RUN if \
        [ $XDEBUG_ENABLED = "true" ] ; \
    then \
        echo '\
xdebug.remote_host='$XDEBUG_REMOTE_HOST'\n\
xdebug.remote_port='$XDEBUG_REMOTE_PORT'\n\
xdebug.idekey='$XDEBUG_IDE_KEY'\n\
xdebug.remote_enable=1\n\
xdebug.remote_autostart=1\n\
xdebug.remote_connect_back=off\n\
xdebug.max_nesting_level=1500' >> /usr/local/etc/php/conf.d/xdebug.ini; \
    else \
        rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi

# Expose 80 by default
EXPOSE 80

WORKDIR /var/www/src

CMD ["apache2ctl", "-D", "FOREGROUND"]