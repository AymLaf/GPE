FROM alpine:3.10
  
RUN apk add --update --no-cache nginx vim nmap

COPY nginx.conf /etc/nginx/
COPY reucopro.localhost.conf /etc/nginx/conf.d/
COPY reucopro.admin.localhost.conf /etc/nginx/conf.d/
COPY reucopro.phpmyadmin.localhost.conf /etc/nginx/conf.d/
COPY reucopro.mailcatcher.localhost.conf /etc/nginx/conf.d/

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf
RUN echo "upstream reucopro.localhost { server vue-js:8080; }" >> /etc/nginx/conf.d/upstream.conf
RUN echo "upstream reucopro.phpmyadmin.localhost { server phpmyadmin; }" >> /etc/nginx/conf.d/upstream.conf
RUN echo "upstream reucopro.mailcatcher.localhost { server mailcatcher; }" >> /etc/nginx/conf.d/upstream.conf

RUN adduser -D -g '' -G www-data www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
