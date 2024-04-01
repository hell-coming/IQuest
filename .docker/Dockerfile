FROM harbor.tomsk-it.ru/dockerhub/library/node:20.3.1-slim as nodejs
WORKDIR /app
COPY front ./
RUN npm install
RUN npm run build

FROM harbor.tomsk-it.ru/dockerhub/bitnami/nginx:1.25.1-debian-11-r2 as front
WORKDIR /app
COPY .docker/front-nginx.conf /opt/bitnami/nginx/conf/server_blocks/server.conf
COPY --from=nodejs /app/dist ./

FROM harbor.tomsk-it.ru/dockerhub/library/node:20.3.1-slim as nodejs-back
WORKDIR /app
COPY back ./
RUN npm install
RUN npm run build

FROM harbor.tomsk-it.ru/asap-infra/unit:php8.2-pdo-psql as back
RUN apt-get update && apt-get install -y git unzip libzip-dev libicu-dev libjpeg62-turbo-dev libpng-dev && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install zip && \
    docker-php-ext-configure gd --with-jpeg && docker-php-ext-install exif gd && \
    docker-php-ext-configure intl && docker-php-ext-install intl
COPY .docker/php-override.ini /usr/local/etc/php/conf.d/php-override.ini
COPY --from=harbor.tomsk-it.ru/dockerhub/library/composer:2.5.8 /usr/bin/composer /usr/bin/composer
COPY .docker/unit-config.json /docker-entrypoint.d/
WORKDIR /app
COPY back /app/
COPY --from=nodejs-back /app/public ./public
RUN composer install
RUN chown -R unit:unit /app/
