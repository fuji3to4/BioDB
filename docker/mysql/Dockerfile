FROM mysql:8.0-debian

ENV MYSQL_ROOT_PASSWORD=password
ENV TZ=Asia/Tokyo

#日本語環境構築
RUN apt-get update \
    && apt-get install -y locales \
    && sed -i -e 's/# \(ja_JP.UTF-8\)/\1/' /etc/locale.gen \
    && locale-gen \
    && update-locale LANG=ja_JP.UTF-8

ENV LC_ALL=ja_JP.UTF-8
ENV LANG=ja_JP.UTF-8

#mysqlのカスタム設定(windowsだと読み込み専用ファイルにしないといけないための措置)
COPY ./mycustom.cnf /etc/mysql/conf.d/mycustom.cnf
RUN chmod 644 /etc/mysql/conf.d/mycustom.cnf

#データベース操作権限持ったuser作成用のsqlを起動後に実行されるDirにコピー
COPY ./init.sql /docker-entrypoint-initdb.d/init.sql 

#log出力を設定すると起動時にエラーで落ちるための対策。
RUN rm -rf /var/log/mysql \
    && mkdir /var/log/mysql 
RUN chmod 777 /var/log/mysql

#初期の設定
ARG UNAME=user
ARG GNAME=user
RUN groupadd $GNAME \
    && useradd -m -s /bin/bash -g $GNAME $UNAME

WORKDIR /home/$UNAME/SQL
USER $UNAME

