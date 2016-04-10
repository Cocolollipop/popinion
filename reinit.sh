php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:schema:drop --force
php bin/console doctrine:schema:create
php bin/console doctrine:fixtures:load -n
php bin/console cache:clear
php bin/console assets:install
