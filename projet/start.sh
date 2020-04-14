printf "\n"
echo "================INFO=================="
echo " Deploying Developpement Environnment "
echo "======================================"
printf "\n"

sh stop.sh
docker-compose stop
docker-compose up --build -d

docker exec -it reucopro_nginx sh -c "chown -R www-data:www-data /var/tmp/nginx/"
docker exec -it reucopro_php sh -c "chown -R 1000:1000 /var/www/api_bo"

printf "\n"
echo "================INFO========================"
echo " Composer install - Reucopro API/Backoffice "
echo "============================================"
printf "\n"

docker exec -it reucopro_php sh -c "composer update -d /var/www/api_bo"
docker exec -it reucopro_php sh -c "mkdir -p /var/www/api_bo/config/jwt && chmod 777 /var/www/api_bo/config/jwt"

printf "\n"
echo "================INFO=============="
echo " Assets - Reucopro API/Backoffice "
echo "=================================="
printf "\n"

docker exec -it reucopro_php sh -c "yarn install"
docker exec -it reucopro_php sh -c "yarn encore dev"

printf "\n"
echo "========INFO======="
echo " Launching Tests ! "
echo "==================="
printf "\n"

docker exec -it reucopro_php sh -c "php ./bin/phpunit"