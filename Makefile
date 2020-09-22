CMD_DOCKER_COMPOSE := docker-compose
CMD_CS_FIXER_FIX := php vendor/bin/php-cs-fixer fix  --config=.php_cs

start:
	@echo Starting project...
	${CMD_DOCKER_COMPOSE} up -d
	@echo Project has been started.

stop:
	@echo Stopping project...
	${CMD_DOCKER_COMPOSE} down
	@echo Project has been stopped.

kill:
	@echo Killing project...
	${CMD_DOCKER_COMPOSE} kill
	@echo Project has been killed.

composer:
	@echo Performing composer command...
	${CMD_DOCKER_COMPOSE} exec php composer $(command)
	@echo Composer command completed.

console:
	@echo Executing symfony console command...
	${CMD_DOCKER_COMPOSE} exec php bin/console $(command)
	@echo Symfony console command executed.

exec:
	@echo Executing command...
	${CMD_DOCKER_COMPOSE} exec $(command)
	@echo Command executed.

php-cs-fixer:
	${CMD_CS_FIXER_FIX} src --dry-run --verbose --diff;

unit-test:
	${CMD_DOCKER_COMPOSE} exec php vendor/bin/phpunit;
