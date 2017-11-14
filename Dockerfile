FROM php:7.1-apache

# Install system dependencies
RUN    apt-get update \
    && apt-get -yq install \
        curl \
        php5-curl \
        libapache2-mod-macro \
        git \
        libpng12-dev libjpeg-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
	&& docker-php-ext-install gd zip

# Install and configure XDebug
RUN pecl install xdebug-2.5.5 && docker-php-ext-enable xdebug

RUN echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo 'xdebug.remote_host=10.254.254.254' >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo 'xdebug.remote_enable=on' >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo 'xdebug.remote_autostart=on' >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo 'xdebug.remote_connect_back=off' >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo 'xdebug.remote_handler=dbgp' >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo 'xdebug.profiler_enable=0' >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo 'xdebug.profiler_output_dir="/var/www/html"' >> /usr/local/etc/php/conf.d/xdebug.ini

# Copy composer json, lock and phar
COPY ./www/composer.* /var/www/html/www/

# Now install the dependences
RUN php /var/www/html/www/composer.phar install --no-scripts --no-autoloader --working-dir=/var/www/html/www

# Now copy de application's source code
COPY ./www /var/www/html

# And now dump the autoload
RUN php /var/www/html/www/composer.phar dump-autoload --optimize

WORKDIR /var/www/html

# Configure Apahce
ADD ./deploy/apache/main.conf /etc/apache2/sites-available/main.conf

## Enable rewrite module
RUN a2enmod rewrite macro

## Enable the site
RUN a2dissite 000-default && a2ensite main

# Don't listen by default port 80 (see comment in main.conf)
RUN sed -i 's/^Listen 80/#Listen80/' /etc/apache2/ports.conf

# Run apache
ADD ./deploy/apache/run.sh  /run.sh
RUN chmod 777 /run.sh
USER www-data
CMD ["/run.sh"]
