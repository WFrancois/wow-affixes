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
RUN apt update && apt upgrade -y
RUN apt install python zip libzip-dev -y

# Setup NGINX
RUN apt install nginx -y
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
