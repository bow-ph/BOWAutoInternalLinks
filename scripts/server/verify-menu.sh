#!/bin/bash
set -e

SHOPWARE_DIR="/var/www/shopware6"
cd $SHOPWARE_DIR

# Check menu registration
bin/console cache:clear
bin/console theme:compile
bin/console assets:install

# Verify plugin status
bin/console plugin:list | grep BOWAutoInternalLinks

# Check compiled assets
ls -la public/bundles/bowautointernallinks/administration/js/b-o-w-auto-internal-links.js || echo "Bundle not found"

# Check menu registration in compiled js
grep -r "sw.marketing.index" public/bundles/bowautointernallinks/administration/js/b-o-w-auto-internal-links.js || echo "Menu registration not found in compiled js"
