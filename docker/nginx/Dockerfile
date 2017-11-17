FROM debian:jessie

MAINTAINER Michel NAUD <mitch@kilik.fr>

RUN apt-get update && apt-get install -y \
    nginx

ADD nginx.conf /etc/nginx/
RUN rm -f /etc/nginx/sites-enabled/default
ADD symfony.conf /etc/nginx/sites-enabled/

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
