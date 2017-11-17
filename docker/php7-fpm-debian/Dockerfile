FROM debian:stretch

MAINTAINER Michel NAUD <mitch@kilik.fr>

RUN DEBIAN_FRONTEND=noninteractive apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get upgrade -y && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    ca-certificates \
    iptables \
    git \
    curl \
    openssh-client \
    nano \
    php7.0-bz2 \
    php7.0-cli \
    php7.0-curl \
    php7.0-fpm \
    php7.0-gd \
    php7.0-imap \
    php7.0-intl \
    php7.0-json \
    php7.0-ldap \
    php7.0-mbstring \
    php7.0-mcrypt \
    php7.0-mysql \
    php7.0-opcache \
    php7.0-odbc \
    php7.0-pgsql \
    php7.0-sqlite3 \
    php7.0-tidy \
    php7.0-xdebug \
    php7.0-xsl \
    php7.0-zip \
    php-apcu \
    php-bcmath \
    php-geoip \
    php-imagick \
    php-mongodb \
    php-ssh2 \
    php-memcache \
    php-tideways \
    phpunit

# Get latest version of nodejs
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y curl gnupg
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -

RUN DEBIAN_FRONTEND=noninteractive apt-get install -y nodejs

# Common tools
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y zip wget unzip

# Additional tools
# removed, use web service instead
#RUN DEBIAN_FRONTEND=noninteractive apt-get install -y wkhtmltopdf xvfb

# clean all apt cache information
RUN DEBIAN_FRONTEND=noninteractive apt-get clean && \
    rm -Rf /var/lib/apt/lists/* /usr/share/man/* /usr/share/doc/*

COPY php-cli.ini    /etc/php/7.0/cli/conf.d/30-custom-php.ini
COPY php-fpm.ini    /etc/php/7.0/fpm/conf.d/30-custom-php.ini
COPY www.conf       /etc/php/7.0/fpm/pool.d/

# For custom Configuration that comes from outside (via a docker compose mount)
RUN mkdir /etc/php/7.0/fpm/user-conf.d
RUN echo "; Default empty file" > /etc/php/7.0/fpm/user-conf.d/example.conf
RUN mkdir /var/log/php

# install bower (todo: remove when migrated to yarn)
RUN npm install -g bower

# Install yarn
RUN npm install -g yarn

# Create home for www-data
RUN mkdir -p /run/php
RUN chown www-data:www-data /run/php
RUN mkdir -p /var/www/home
RUN chown www-data:www-data /var/www
RUN sed -i 's/\/var\/www/\/var\/www\/home/g' /etc/passwd

# start service
COPY run.sh     /run.sh
RUN  chmod +x    /run.sh

# nice shell defaults
COPY .bashrc /root/.bashrc
COPY .bashrc /var/www/home/.bashrc

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Install symfony installer
RUN curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
RUN chmod a+x /usr/local/bin/symfony
RUN symfony --version

# Install PHP CS
RUN wget http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -O php-cs-fixer \
    && chmod +x php-cs-fixer \
    && mv php-cs-fixer /usr/local/bin/php-cs-fixer

# install and active xdebug
RUN DEBIAN_FRONTEND=noninteractive apt-get install php-xdebug
RUN phpenmod xdebug
COPY xdebug.ini /etc/php/7.0/mods-available/xdebug.ini

ENV ENVIRONMENT dev
ENV FPM_UID 33
ENV FPM_GID 33

EXPOSE 9000

CMD ["/run.sh"]

WORKDIR /var/www/html
