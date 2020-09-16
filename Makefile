CMD_DOCKER_COMPOSE := docker-compose

build:
	@echo Building project...w
	${CMD_DOCKER_COMPOSE} build -d
	@echo Project has been built.

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