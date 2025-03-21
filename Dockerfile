FROM ghcr.io/atomicptr/boxed-php:8.4

COPY . /app

ENV APP_NAME=Nimbus
ENV APP_ENV=production
ENV APP_FORCE_HTTPS=false
ENV APP_DEBUG=false
ENV APP_TIMEZONE=UTC
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/app/storage/database.sqlite

WORKDIR /app

RUN mkdir -p /app/bootstrap/cache && \
    mkdir -p /app/storage/framework/sessions && \
    mkdir -p /app/storage/framework/views && \
    mkdir -p /app/storage/framework/cache && \
    mkdir -p /app/storage/logs

RUN touch /app/storage/database.sqlite
RUN chown -R www-data:www-data /app/storage
RUN chmod -R g+rws /app/storage

RUN composer install
RUN php artisan filament:cache-components

# necessary for optimize
RUN mkdir -p resources/views
RUN php artisan optimize

HEALTHCHECK --interval=30s --timeout=5s CMD curl -f http://localhost/up || exit 1
