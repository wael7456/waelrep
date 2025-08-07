# Builder 
FROM composer:2.7 AS builder
WORKDIR /app
COPY composer.json composer.lock symfony.lock ./
RUN composer install --no-dev --no-scripts --optimize-autoloader --no-cache --no-plugins
COPY src/ src/
COPY config/ config/
COPY public/ public/
COPY bin/ bin/
COPY .env* ./
RUN composer dump-autoload --optimize --classmap-authoritative \
    && find /app/vendor -name "*.md" -delete \
    && find /app/vendor -name "*.txt" -delete \
    && find /app/vendor -name "tests" -type d -exec rm -rf {} + 2>/dev/null || true \
    && find /app/vendor -name "docs" -type d -exec rm -rf {} + 2>/dev/null || true

# Runtime - Image PHP officielle mais slim
FROM php:8.2-apache-bookworm
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev libpq-dev \
    && docker-php-ext-install intl pdo_pgsql \
    && a2enmod rewrite \
    && apt-get purge -y --auto-remove libicu-dev libpq-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* /usr/share/man/* /var/cache/debconf/*

# Copier seulement l'essentiel
COPY --from=builder --chown=www-data:www-data /app/vendor /var/www/html/vendor
COPY --from=builder --chown=www-data:www-data /app/src /var/www/html/src
COPY --from=builder --chown=www-data:www-data /app/config /var/www/html/config
COPY --from=builder --chown=www-data:www-data /app/public /var/www/html/public
COPY --from=builder --chown=www-data:www-data /app/bin /var/www/html/bin
COPY --from=builder --chown=www-data:www-data /app/composer.json /var/www/html/

# Créer les dossiers cache minimaux
RUN mkdir -p /var/www/html/var/cache /var/www/html/var/log

EXPOSE 80