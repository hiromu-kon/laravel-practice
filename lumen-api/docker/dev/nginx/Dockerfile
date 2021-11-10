FROM nginx:1.18-alpine

ENV TZ=UTC

# nginx config file
COPY ./docker/dev/nginx/*.conf /etc/nginx/conf.d/

WORKDIR /var/www/html
