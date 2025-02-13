#!/bin/bash
set -e

SHOPWARE_DIR="/var/www/shopware6"
cd $SHOPWARE_DIR

# Build administration
sudo -u www-data bin/console bundle:dump
sudo -u www-data bin/console feature:dump
sudo -u www-data bin/console theme:dump
sudo -u www-data bin/build-administration.sh

# Clear cache
sudo -u www-data bin/console cache:clear
