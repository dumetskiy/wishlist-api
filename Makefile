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
	@echo Performing composer install...
	${CMD_DOCKER_COMPOSE}  exec php composer install
	@echo Composer install completed.