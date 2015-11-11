#!/usr/bin/env bash

## Vagrant provision script, which
#  is going install required software
#  and packages to "ubuntu/trusty32" 
#  vagrant base box.

# Settings
MYSQL_ROOT_PASSWORD="secret"

# Update package index
apt-get -y update

# Install basic packages
apt-get -y install git tree

# Install apache
apt-get -y install apache2
echo ServerName $HOSTNAME >> /etc/apache2/apache2.conf
a2enmod rewrite
service apache2 restart

# Install mysql
debconf-set-selections <<< "mysql-server mysql-server/root_password password $MYSQL_ROOT_PASSWORD"
debconf-set-selections <<< "mysql-server mysql-server/root_password_again password $MYSQL_ROOT_PASSWORD"
apt-get -y install mysql-server php5-mysql mysql-client
touch /home/vagrant/.my.cnf
cat > /home/vagrant/.my.cnf <<EOL
[mysql]
character-sets-dir       = /usr/share/mysql/charsets
default-character-set    = utf8
user                     = root
password                 = ${MYSQL_ROOT_PASSWORD}
pager                    = less
show-warnings
EOL
chown vagrant:vagrant /home/vagrant/.my.cnf

# Install PHP
apt-get install -y php5 libapache2-mod-php5 php5-mcrypt php5-curl
php5enmod mcrypt
service apache2 restart

# Some apache config stuff
mv /etc/apache2/mods-enabled/dir.conf /etc/apache2/mods-enabled/dir.conf.old 
touch /etc/apache2/mods-enabled/dir.conf
cat > /etc/apache2/mods-enabled/dir.conf <<EOL
<IfModule mod_dir.c>
    DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>
EOL
touch /etc/apache2/sites-available/currency.conf
cat > /etc/apache2/sites-available/currency.conf <<EOL
<VirtualHost *:80>
    DocumentRoot "/vagrant/public"
    <Directory "/vagrant/public">
        AllowOverride all
        Require all granted
    </Directory>
</VirtualHost>
EOL
a2dissite 000-default.conf && a2ensite currency.conf && service apache2 restart
usermod -aG vagrant www-data

# Install nodejs
apt-get install -y nodejs npm
ln -s "$(which nodejs)" /usr/bin/node
