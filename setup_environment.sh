make start
make composer command="install"
make console command="doctrine:database:create"
make console command="doctrine:migrations:migrate"