# BioDB

バイオデータベース演習用DockerによるLAMP+Next.js環境(mysql:9.3.0, php:8.3.20-apache-bookworm, node:22.15.0-slim)

※演習用に便宜上セキュリティを甘く構築しているので一般用途には向きません。

## Install
```
cd ./BioDB/docker
docker compose up -d
```

## Usage
### 動作確認
```
docker ps
CONTAINER ID   IMAGE          COMMAND                   CREATED          STATUS          PORTS                 NAMES
7577ec77e36e   docker-php     "docker-php-entrypoi…"   32 minutes ago   Up 32 minutes   0.0.0.0:80->80/tcp    docker-php
78a682eabd52   docker-mysql   "docker-entrypoint.s…"   32 minutes ago   Up 32 minutes   3306/tcp, 33060/tcp   docker-mysql
```

### PHP
./BioDB/html/はdocker-phpの/html(/var/www/html/)と同期しています。
その中に作成したhtmlやphpに以下のようなURLによりアクセスできます。
http://localhost/sample.php

![image](https://github.com/fuji3to4/BioDB/assets/72539480/bb2f6935-a911-4499-8d68-999ded20f04c)


### MySQL
./BioDB/SQL/はdocker-mysqlの/home/user/SQLと同期しています。
```
docker exec -it docker-mysql bash
```
練習用のsqlは以下のようにしてインポートして利用してください。
```
mysql -uroot -ppassword < setting.sql
mysql -uroot -ppassword 
```
```
mysql: [Warning] Using a password on the command line interface can be insecure.
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 10
Server version: 8.0.33 MySQL Community Server - GPL

Copyright (c) 2000, 2023, Oracle and/or its affiliates.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql>
```
