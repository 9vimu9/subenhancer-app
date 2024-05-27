#!/bin/bash

source .env

# copy pre-commit
\cp -r git/hooks .git/
chmod +x .git/hooks/pre-commit

timestamp=$(date +%s)

#dump before refresh
mysqldump -h0.0.0.0 -P$FORWARD_DB_PORT -u root -p$DB_PASSWORD $DB_DATABASE corpuses > "${timestamp}-corpuses.sql"
mysqldump -h0.0.0.0 -P$FORWARD_DB_PORT -u root -p$DB_PASSWORD $DB_DATABASE definitions > "${timestamp}-definitions.sql"

./vendor/bin/sail php artisan migrate:refresh

#restock
mysql -h0.0.0.0 -P$FORWARD_DB_PORT -u root -p$DB_PASSWORD $DB_DATABASE < "${timestamp}-corpuses.sql"
mysql -h0.0.0.0 -P$FORWARD_DB_PORT -u root -p$DB_PASSWORD $DB_DATABASE < "${timestamp}-definitions.sql"
# run essential seeds
./vendor/bin/sail php artisan db:seed

