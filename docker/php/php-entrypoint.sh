#!/bin/bash
set -e

if [[ -z "$*" ]]; then

  if [[ -f "composer.json" ]]; then
    echo "Installing dependencies"
    composer install

  fi

  if [[ -f "bin/console" ]]; then
    echo "Running migrations"
    php bin/console doctrine:migrations:migrate --no-interaction
  fi

  echo "Running SUPERVISORD"
  sudo supervisord -c /etc/supervisord.conf

  echo "Running PHP-FPM"
  exec php-fpm
else
  exec "$@"
fi
