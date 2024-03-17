FROM dunglas/frankenphp:latest-php8.3

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . /app

ENV APP_NAME Nimbus
ENV APP_ENV production
ENV APP_DEBUG false
ENV APP_TIMEZONE UTC
ENV DB_CONNECTION sqlite
ENV DB_DATABASE /app/data/database.sqlite
ENV OCTANE_SERVER frankenphp

RUN install-php-extensions \
    intl \
    zip \
    pcntl

WORKDIR /app

RUN mkdir -p /app/bootstrap/cache && \
    mkdir -p /app/storage/framework/sessions && \
    mkdir -p /app/storage/framework/views && \
    mkdir -p /app/storage/framework/cache && \
    mkdir -p /app/storage/logs && \
    touch /app/storage/logs/octane-server-state.json

RUN composer install

CMD ["php", "artisan", "octane:start", "--port=8000"]
