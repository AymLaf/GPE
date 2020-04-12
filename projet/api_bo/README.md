API/BO Documentation
=================

### Installation
PHPSTAN check (configuation file `phpstan.neon`) :
```bash
$ docker exec -it reucopro_php sh -c "/var/www/api_bovendor/bin/phpstan analyse -c phpstan.neon"
```

###TESTS
Creation de tests dans le folder test (cqfd)
```
docker exec reucopro_php ./bin/phpunit
```