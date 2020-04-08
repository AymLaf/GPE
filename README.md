# Reucopro - Groupe obadia_r

## Requirements :
- Docker
- Bash shell
- NPM

## First run
You can read more about scripts in the "[About scripts](./README.md#about-scripts)" section bellow
### Installation
Start services through docker containers :
```bash
# Warning : this script will remove your running docker's containers
$ sh start.sh
```

JWT token setup (recommended passphrase : reucopro) :
```bash
# Warning : interactive commands
$ docker exec -it reucopro_php sh -c "openssl genrsa -out config/jwt/private.pem -aes256 4096"
$ docker exec -it reucopro_php sh -c "openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem"
```

Creation of the database :
```bash
$ sh db.sh
```

[Optional - Recommended] Loading fixtures :
```bash
$ sh fixtures.sh
```
### Informations
- Super admin user credentials : admin@reucopro.com - admin
- If you don't have setup the JWT passphrase to "reucopro" then please override `JWT_PASSPHRASE` in a file name `api/.env.local` with your value
- Database datas will persist if services shutdown

## Rerun the project
Start services :
```bash
# Warning : this script will remove your running docker's containers
$ sh start.sh
```

## About scripts
- stop.sh :
    - Stop and remove all running containers
- start.sh :
    - run `stop.sh`
    - run docker compose
    - run composer update for the API/Backoffice (`api_bo/`) through "reucopro_php" container
- db.sh :
    - drop database through "reucopro_php" container with Doctrine
    - create database through "reucopro_php" container with Doctrine
    - create schema through "reucopro_php" container with Doctrine
- fixtures.sh :
    - load fixtures for fake datas through "reucopro_php" container with Doctrine

## Services URLs
- API : http://reucopro.admin.localhost/api (add "/doc" to see ApiPlatform documentation)
- Backoffice : http://reucopro.admin.localhost
- Front : http://localhost:5050
- PhpMyAdmin : http://reucopro.phpmyadmin.localhost/ (Automatic connexion)
- Mailcatcher : http://reucopro.mailcatcher.localhost/

## Services docs
- [API/BO](/projet/api_bo/README.md#apibo-documentation)



## FRONT - TODO UN TRUC PROPRE ET A RANGER AVEC LES SECTIONS EXISTANTES

Install nvm 
- curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash
- export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"

Install and use LongTermSupport Node Version
- nvm install --lts
- nvm use --lts

Install Vue CLI
npm install -g @vue/cli

vue create front