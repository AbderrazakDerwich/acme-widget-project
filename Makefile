ifneq (,$(wildcard ./.env))
    include .env
    export
endif

DC=docker compose

up:
	@$(DC) up -d
install:
	@$(DC) exec -it php sh -c "composer install"
down:
	@$(DC) down
ps:
	@$(DC) ps

info:
	@echo "------ App deployed at : http://localhost:${NGINX_PORT}"
	@echo "------ Phpmyadmin deployed at : http://localhost:${PHPMYADMIN_PORT}"