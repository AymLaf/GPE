FROM node:lts-alpine

RUN npm install -g http-server

WORKDIR /app

COPY ./app/package*.json ./

RUN npm install

COPY ./app .

EXPOSE 8080

CMD [ "npm", "run", "serve" ]
