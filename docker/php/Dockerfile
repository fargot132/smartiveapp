FROM php:8.3-fpm AS php_base

ARG LOCAL_UID
ARG LOCAL_GID

RUN if [ ${LOCAL_UID:-0} -ne 0 ] && [ ${LOCAL_GID:-0} -ne 0 ]; then \
    usermod -u ${LOCAL_UID} www-data &&\
    groupmod -g ${LOCAL_GID} www-data \
;fi

COPY ./docker/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/php/php-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/php-entrypoint.sh
ENTRYPOINT ["php-entrypoint.sh"]

FROM php_base AS php
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt-get update && apt-get install -y libzip-dev libpng-dev libjpeg-dev libfreetype-dev supervisor git unzip && rm -rf /var/lib/apt/lists/* \
     && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd zip pdo_mysql exif

