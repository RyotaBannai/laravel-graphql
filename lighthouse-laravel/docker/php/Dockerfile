FROM php:7.2-fpm

# Install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim \
libpq-dev \
nodejs npm \
supervisor \
&& docker-php-ext-install pdo_mysql pdo_pgsql pcntl \
&& mkdir -p /etc/supervisor/conf.d \
&& touch /var/run/supervisor.sock && chmod 777 /var/run/supervisor.sock

WORKDIR /var/www/html
