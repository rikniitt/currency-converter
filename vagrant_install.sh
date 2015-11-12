#!/usr/bin/env bash

## Vagrant provision script, which
#  is supposed to run as non-privileged
#  user. Script installs the project
#  and required dependencies.

MYSQL_ROOT_PASSWORD=$1

# First, go to project dir
cd /vagrant/

# Install composer
curl -sS https://getcomposer.org/installer | php

# Install php dependencies
php composer.phar install --no-interaction --no-progress

# Create database
mysql -hlocalhost -uroot -p"$MYSQL_ROOT_PASSWORD"  -e"CREATE DATABASE currconv"

# Edit and create config file
cp .env.example .env
cp .env .env.temp
sed -e "s/DB_DATABASE=homestead/DB_DATABASE=currconv/g" < .env.temp > .env
cp .env .env.temp
sed -e "s/DB_USERNAME=homestead/DB_USERNAME=root/g" < .env.temp > .env
cp .env .env.temp
sed -e "s/DB_PASSWORD=secret/DB_PASSWORD=$MYSQL_ROOT_PASSWORD/g" < .env.temp > .env
rm .env.temp

# Initialize database tables
php artisan migrate
php artisan db:seed
