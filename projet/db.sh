#!/bin/bash

docker exec -it reucopro_php sh -c "php /var/www/api_bo/bin/console doctrine:database:drop --force"
docker exec -it reucopro_php sh -c "php /var/www/api_bo/bin/console doctrine:database:create"
docker exec -it reucopro_php sh -c "php /var/www/api_bo/bin/console doctrine:schema:create"
