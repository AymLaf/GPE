#!/bin/bash

docker exec -it reucopro_php sh -c "php bin/console doctrine:database:drop --force"
docker exec -it reucopro_php sh -c "php bin/console doctrine:database:create"
docker exec -it reucopro_php sh -c "php bin/console doctrine:schema:create"
docker exec -it reucopro_php sh -c "php -d memory_limit=-1 bin/console doctrine:fixtures:load --no-interaction --env=dev -v"
