FROM php:7.0-apache

# Install Apache PHP mod and its dependencies (including Apache and PHP!), and git, zip and unzip in case composer needs it
RUN    apt-get update \
    && apt-get -yq install \
        curl \
        php5-curl \
        libapache2-mod-macro \
        git \
        zip unzip \
    && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

# Copy composer json and lock
COPY ./www/composer.json ./www/composer.* /var/www/html/www/

# Now install the dependences
RUN composer install --no-scripts --no-autoloader --working-dir=/var/www/html/www

# Now copy de application's source code
COPY ./www /var/www/html

# And now dump the autoload
RUN composer dump-autoload --optimize

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
