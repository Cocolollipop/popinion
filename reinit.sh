php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console cache:clear
php bin/console assets:install
