#!/bin/bash
ADMIN_DIR="/var/www/shopware6/custom/plugins/BOWAutoInternalLinks/src/Resources/app/administration"
inotifywait -m -r -e modify,create,delete $ADMIN_DIR |
while read path action file; do
    if [[ "$file" =~ \.(js|vue|scss|css)$ ]]; then
        echo "Changes detected in $path$file"
        ./build-admin.sh
    fi
done
