FROM php:7.2.4-cli-alpine3.7

MAINTAINER	PFinal "lampxiezi@163.com"

RUN echo http://mirrors.ustc.edu.cn/alpine/v3.7/main > /etc/apk/repositories && \
echo http://mirrors.ustc.edu.cn/alpine/v3.7/community >> /etc/apk/repositories
RUN apk update && apk upgrade
RUN apk add m4 autoconf make gcc g++ linux-headers
ADD ./install/swoole-4.2.1.tgz /tmp/
RUN cd /tmp/swoole-4.2.1 && phpize && ./configure && make && make install
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-enable swoole
WORKDIR /srv/www
EXPOSE 80
CMD ["php","-m"]