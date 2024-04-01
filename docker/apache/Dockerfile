FROM php:8.0-apache

# Update and install required packages
RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
        openssl \
  && docker-php-ext-install zip mysqli

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache mod_rewrite and mod_ssl for URL rewriting and SSL support
RUN a2enmod rewrite ssl

# Create a directory to store SSL certificates
RUN mkdir /etc/apache2/ssl

# Generate a self-signed SSL certificate for localhost
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/apache2/ssl/apache.key \
    -out /etc/apache2/ssl/apache.crt \
    -subj "/C=US/ST=Denial/L=Springfield/O=Dis/CN=localhost"

# Copy and enable SSL configuration parameters
COPY ssl-params.conf /etc/apache2/conf-available/ssl-params.conf
RUN a2enconf ssl-params

# Correct paths in default-ssl.conf to use generated self-signed certificates
RUN sed -i 's|SSLCertificateFile.*|SSLCertificateFile /etc/apache2/ssl/apache.crt|' /etc/apache2/sites-available/default-ssl.conf && \
    sed -i 's|SSLCertificateKeyFile.*|SSLCertificateKeyFile /etc/apache2/ssl/apache.key|' /etc/apache2/sites-available/default-ssl.conf

# Enable the default SSL site
RUN a2ensite default-ssl

RUN apt-get update && apt-get install -y nano

