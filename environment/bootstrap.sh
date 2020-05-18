#!/usr/bin/env bash
apt update
apt install -y apache2
apt install -y php
apt install -y mysql-server
apt install -y php-xdebug php-xml php-mbstring php-curl
cp /var/www/html/environment/xdebug.ini /etc/php/7.2/cli/conf.d/20-xdebug.ini
cp /var/www/html/environment/mysqld.cnf /etc/mysql/mysql.conf.d/mysqld.cnf
systemctl reload apache2
systemctl restart mysql