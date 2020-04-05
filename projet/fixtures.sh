#!/bin/bash

docker exec -it reucopro_php sh -c "php -d memory_limit=-1 /var/www/api_bo/bin/console doctrine:fixtures:load --no-interaction --env=dev -v"
