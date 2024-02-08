# Build PHP dependencies
FROM composer:2 as vendor-build
WORKDIR /app
COPY ./composer.json ./composer.lock /app/
RUN composer install \
    --optimize-autoloader \
    --no-dev \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# Build Node dependencies
FROM node:lts AS node-build
RUN mkdir -p /app/public
COPY ./package.json ./package-lock.json ./vite.config.js /app/
COPY ./resources/ /app/resources/
WORKDIR /app
RUN npm install && npm run build

# Production stage
FROM php:8.1-apache



# See https://github.com/mlocati/docker-php-extension-installer for documentation
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
# Install needed php extensions
RUN install-php-extensions \
      bcmath \
      opcache \
      pdo_mysql \
      zip \
      xmlreader \
      gd

# Install Supervisor
RUN apt-get update

RUN apt-get -y install vim

RUN DEBIAN_FRONTEND=noninteractive; apt-get install -y --no-install-recommends supervisor dos2unix && \
  rm -rf /var/lib/apt/lists/*
# Setup Supervisor
RUN mkdir -p /var/log/supervisor && \
    mkdir -p /var/run/supervisor && \
    chown -R www-data:www-data /var/log/supervisor /var/run/supervisor
COPY ./supervisor/apache2.conf /etc/supervisor/conf.d/apache2.conf
COPY ./supervisor/worker.conf /etc/supervisor/conf.d/worker.conf
COPY ./supervisor/supervisord.conf /etc/supervisor/supervisord.conf

# Setup Apache mods
RUN a2enmod rewrite expires headers

# Override Apache port to use 8888
RUN sed -i "s/^Listen.*/Listen 8888/g" "/etc/apache2/ports.conf"
RUN sed -i "s/VirtualHost \*\:80/VirtualHost \*\:8888/g" /etc/apache2/sites-available/*.conf
# Setup Apache to use public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# Apache Security modifications
ENV SECURITY_CONF_FILE /etc/apache2/conf-enabled/security.conf
RUN sed -i "s/^ServerTokens.*$/ServerTokens Prod/g" "${SECURITY_CONF_FILE}"
RUN sed -i "s/^ServerSignature.*$/ServerSignature Off/g" "${SECURITY_CONF_FILE}"
RUN sed -i "s/^\#Header/Header/g" "${SECURITY_CONF_FILE}"

COPY --from=vendor-build /usr/bin/composer /usr/local/bin/composer

# Copy data
WORKDIR /var/www/html
COPY . .
# Copy PHP dependencies
COPY --from=vendor-build /app/vendor/ ./vendor/
# Copy Node dependencies
COPY --from=node-build /app/public/ ./public/
#COPY --from=node-build /app/public/css/ ./public/css/
#COPY --from=node-build /app/mix-manifest.json ./public/mix-manifest.json
# Fix ownership
RUN chown -R www-data:www-data /var/www/

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]

EXPOSE 8888
USER www-data
