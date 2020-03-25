FROM node:lts-alpine

# installe un simple serveur http pour servir un contenu statique
RUN npm install -g http-server

# définit le dossier 'app' comme dossier de travail dans le container
WORKDIR /app

# copie 'package.json' et 'package-lock.json' (si disponible)
COPY /home/augustin/ETNA/Master/GPE/projet/front/app/package.json ./

# installe les dépendances du projet
RUN npm install

# copie les fichiers et dossiers du projet dans le dossier de travail (par exemple : le dossier 'app')
COPY . .

EXPOSE 8080
CMD [ "npm run dev" ]