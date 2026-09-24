# This is not how a dockerfile should be (best would be to run fpm & nginx as separate container)

FROM node:14 AS node
FROM php:7.4-fpm

LABEL com.centurylinklabs.watchtower.stop-signal="SIGKILL"
LABEL com.centurylinklabs.watchtower.enable="true"

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

RUN npm i -g npm@6
# bullseye is EOL: use archive.debian.org
RUN sed -i \
      -e 's|deb.debian.org/debian|archive.debian.org/debian|g' \
      -e '/bullseye-updates/d' \
      -e '/debian-security/d' \
      /etc/apt/sources.list \
 && echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99archive

RUN apt-get update \
 && apt-get install -y --no-install-recommends python zip libzip-dev nginx \
 && rm -rf /var/lib/apt/lists/*

# Setup NGINX
RUN rm /etc/nginx/sites-enabled/default
COPY ./deploy/nginx/nginx.conf /etc/nginx/sites-enabled/wowaffixes


RUN docker-php-ext-install zip opcache
COPY deploy/php/opcache.ini "$PHP_INI_DIR/conf.d/opcache.ini"

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /home/app

COPY . .

RUN npm ci

RUN echo "APP_ENV=prod" >> .env

RUN composer install --no-dev --optimize-autoloader

RUN npm run build

EXPOSE 80

RUN ["chmod", "+x", "./deploy/entrypoint.sh"]
CMD ["./deploy/entrypoint.sh"]
