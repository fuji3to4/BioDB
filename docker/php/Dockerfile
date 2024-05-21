FROM php:8.3.7-apache

ENV TZ=Asia/Tokyo

COPY php.ini /usr/local/etc/php/

RUN apt-get update \
    && apt-get install -y libonig-dev \
    && docker-php-ext-install pdo_mysql mysqli mbstring

#Userdir有効化
RUN a2enmod userdir

#初期の設定
ARG UNAME=user
ARG GNAME=user
RUN groupadd $GNAME && \
    useradd  -m -s /bin/bash -g $GNAME $UNAME

#WORKDIR /html
#RUN rm -rf /var/www/html
#RUN ln -s /html /var/www/html 
#    && chown $UNAME.$GNAME /html && chmod 755 /html #docker volumeをマウントさせると結局rootになるので省略

WORKDIR /home/$UNAME/public_html

USER $UNAME