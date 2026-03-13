FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts

FROM php:8.2-cli
WORKDIR /app

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=vendor /app/vendor /app/vendor
COPY . .

RUN chmod +x /app/entrypoint.sh \
    && mkdir -p /app/database /app/storage/framework/cache/data /app/storage/framework/sessions /app/storage/framework/views /app/storage/logs

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV APP_URL=http://localhost
ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/app/database/database.sqlite
ENV SESSION_DRIVER=file
ENV CACHE_STORE=file
ENV QUEUE_CONNECTION=sync
ENV LOG_CHANNEL=stderr
ENV PORT=8090

EXPOSE 8090

CMD ["/app/entrypoint.sh"]
