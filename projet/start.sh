sh stop.sh
docker-compose stop
docker-compose up --build -d

echo $'\n'
echo "Composer install - Symfony API"
docker exec -it reucopro_php sh -c "composer install"
docker exec -it reucopro_php sh -c "mkdir -p /var/www/api/config/jwt && chmod 777 /var/www/api/config/jwt"
