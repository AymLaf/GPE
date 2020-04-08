#!/bin/bash

docker exec -it reucopro_php sh -c "vendor/bin/phpstan analyse -c phpstan.neon"