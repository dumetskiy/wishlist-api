make build
make start
make composer
make console command='doctrine:database:create'
make console command='doctrine:schema:create'
make console command='doctrine:migrations:migrate'