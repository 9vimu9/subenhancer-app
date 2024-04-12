#!/bin/bash
# copy pre-commit
\cp -r git/hooks .git/
chmod +x .git/hooks/pre-commit


./vendor/bin/sail php artisan migrate:refresh

#essential seeds
./vendor/bin/sail php artisan db:seed --class=GenericUserSeeder
./vendor/bin/sail php artisan db:seed --class=LanguageSeeder

