#!/usr/bin/env bash
 
# Variables
DBUSER=root
DBPASSWD=root
DOMAIN=acted.local
DBHOST="127.0.0.1"
DBPORT="3306"

echo "deb http://packages.dotdeb.org jessie all" | sudo tee -a /etc/apt/sources.list
echo "deb-src http://packages.dotdeb.org jessie all" | sudo tee -a /etc/apt/sources.list
wget -q https://www.dotdeb.org/dotdeb.gpg
sudo apt-key add dotdeb.gpg

echo "deb http://repo.mysql.com/apt/debian/ jessie mysql-5.6" | sudo tee -a /etc/apt/sources.list.d/mysql.list
sudo apt-key adv --keyserver pgp.mit.edu --recv-keys 5072E1F5

sudo apt-get update
sudo apt-get install -y debconf-utils

echo -e "Setting up MySQL Server...\n"
export DEBIAN_FRONTEND=noninteractive
sudo debconf-set-selections <<< "mysql-server-5.6 mysql-server/root_password password $DBPASSWD"
sudo debconf-set-selections <<< "mysql-server-5.6 mysql-server/root_password_again password $DBPASSWD"
sudo debconf-set-selections <<< "mysql-community-server mysql-community-server/data-dir select ''"
sudo debconf-set-selections <<< "mysql-community-server mysql-community-server/root-pass password $DBPASSWD"
sudo debconf-set-selections <<< "mysql-community-server mysql-community-server/re-root-pass password $DBPASSWD"

sudo apt-get -y install mysql-server-5.6
mysql_secure_installation
sed -i "s/^bind-address/#bind-address/" /etc/mysql/my.cnf

# echo -e "Setting up MySQL user and DB...\n"
# mysql -uroot -p$DBPASSWD -e "GRANT ALL PRIVILEGES ON *.* TO '$DBUSER'@'%' IDENTIFIED BY '$DBPASSWD' WITH GRANT OPTION;"
# mysql -uroot -p$DBPASSWD -e "FLUSH PRIVILEGES;"
/etc/init.d/mysql restart

echo -e "Setting up Git, MC, PHP5, Xdebug and Composer...\n"
apt-get -y install git mc curl php5 php5-cli php5-curl php5-gd php5-fpm php5-intl php5-mcrypt php5-mysql php5-xdebug php5-dev php-pear php5-imagick imagemagick
sed -i "s/^\;date\.timezone =/date\.timezone = Europe\/Kiev/" /etc/php5/fpm/php.ini
echo "xdebug.max_nesting_level = 250" | sudo tee -a /etc/php5/fpm/conf.d/20-xdebug.ini
echo "xdebug.remote_enable=1" | sudo tee -a /etc/php5/fpm/conf.d/20-xdebug.ini
echo "xdebug.remote_host=10.0.2.2" | sudo tee -a /etc/php5/fpm/conf.d/20-xdebug.ini
echo "xdebug.remote_port=9000" | sudo tee -a /etc/php5/fpm/conf.d/20-xdebug.ini
/etc/init.d/php5-fpm restart

echo -e "Setting up Nginx...\n"
apt-get -y install nginx
cp /vagrant/domain.conf /etc/nginx/sites-available/$DOMAIN
sed -i "s/80/8080/g" /etc/nginx/sites-available/default
sed -i "s/#DOMAIN#/$DOMAIN/g" /etc/nginx/sites-available/$DOMAIN
ln -s /etc/nginx/sites-available/$DOMAIN /etc/nginx/sites-enabled/
service nginx restart

echo -e "Setting up Symfony2...\n"
sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
sudo chmod a+x /usr/local/bin/symfony

echo -e "Setting up a composer + vendor dependencies...\n"
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
cd /vagrant
sudo composer install --no-interaction --ignore-platform-reqs

echo -e "Setting up app/cache and app/logs permissions...\n"
mkdir /vagrant/app/{cache,logs}
chmod 777 -R /vagrant/app/cache/
chmod 777 -R /vagrant/app/logs/
chmod 777 -R /vagrant/app/web/images

echo -e "Setting up parameters.yml file"
cp /vagrant/app/config/parameters.yml.dist /vagrant/app/config/parameters.yml

sed -i "s/\(database_host:\)\s.*/\1 $DBHOST/g" /vagrant/app/config/parameters.yml
sed -i "s/\(database_port:\)\s.*/\1 $DBPORT/g" /vagrant/app/config/parameters.yml
sed -i "s/\(database_name:\)\s.*/\1 $DOMAIN/g" /vagrant/app/config/parameters.yml
sed -i "s/\(database_user:\)\s.*/\1 $DBUSER/g" /vagrant/app/config/parameters.yml
sed -i "s/\(database_password:\)\s.*/\1 $DBPASSWD/g" /vagrant/app/config/parameters.yml

php app/console doctrine:database:create
php app/console --no-interaction doctrine:migrations:migrate

sudo composer install --no-interaction --ignore-platform-reqs --verbose --prefer-dist