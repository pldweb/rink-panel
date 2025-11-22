#!/bin/bash

echo "=============================="
echo "  SERVER SETUP LARAVEL STACK  "
echo "=============================="

# Update & Upgrade
sudo apt update && sudo apt upgrade -y

echo "==> Install Dependensi dasar"
sudo apt install software-properties-common curl zip unzip git ca-certificates lsb-release ufw -y


###########################################
# OPENLITESPEED
###########################################
echo "==> Install OpenLiteSpeed"

wget -O - https://repo.litespeed.sh | sudo bash
sudo apt install openlitespeed -y


###########################################
# PHP 8.4 + EXTENSIONS
###########################################
echo "==> Install PHP 8.4 & Extensions"

sudo apt install lsphp84 lsphp84-common lsphp84-curl lsphp84-mysql \
lsphp84-zip lsphp84-xml lsphp84-mbstring lsphp84-json lsphp84-opcache \
lsphp84-gd lsphp84-intl lsphp84-bcmath lsphp84-pgsql lsphp84-redis \
lsphp84-imap -y


###########################################
# PHP-FPM 8.4 (untuk CLI & Supervisor Worker)
###########################################
echo "==> Install PHP 8.4 FPM & CLI"

sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.4 php8.4-fpm php8.4-cli php8.4-curl php8.4-mysql \
php8.4-zip php8.4-xml php8.4-mbstring php8.4-gd php8.4-bcmath php8.4-intl \
php8.4-readline php8.4-opcache -y


###########################################
# MYSQL SERVER
###########################################
echo "==> Install MySQL Server"
sudo apt install mysql-server -y

sudo systemctl enable mysql
sudo systemctl start mysql


###########################################
# SUPERVISOR
###########################################
echo "==> Install Supervisor"
sudo apt install supervisor -y

sudo systemctl enable supervisor
sudo systemctl start supervisor


###########################################
# NODE.JS LTS (via NodeSource)
###########################################
echo "==> Install Node.js LTS"

curl -fsSL https://deb.nodesource.com/setup_lts.x | sudo -E bash -
sudo apt install -y nodejs


###########################################
# COMPOSER
###########################################
echo "==> Install Composer"

EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]
then
    echo "ERROR: Invalid Composer installer signature!"
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --install-dir=/usr/local/bin --filename=composer
rm composer-setup.php


###########################################
# PERMISSIONS LARAVEL (opsional)
###########################################
echo "==> Set permissions Laravel opsional"
# Uncomment jika mau otomatis
# sudo chown -R www-data:www-data /var/www/laravel
# sudo chmod -R 775 /var/www/laravel/storage /var/www/laravel/bootstrap/cache


###########################################
# FINISH
###########################################
echo "=============================="
echo "  INSTALLATION FINISHED !!!   "
echo "=============================="

echo "OpenLiteSpeed Admin Panel:"
echo "http://SERVER-IP:7080"
echo "Default login:"
echo "  user: admin"
echo "  pass: 123456"
