#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

if [ "$role" = "queue" ]; then

    echo "Running the queue..."
    php /application/artisan queue:work --verbose --tries=3 --timeout=0

elif [ "$role" = "scheduler" ]; then

    while [ true ]
    do
      php /application/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done

else
    php-fpm
fi
