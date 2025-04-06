#!make

default: help

build: ## run docker compose build
	docker compose build

ps: ## docker compose ps
	docker compose ps

up: ## docker compose up
	docker compose up -d

down: ## docker compose down
	docker compose down

down-volumes: ## docker compose down with volumes
	docker compose down --volumes

restart: ## docker compose restart
	docker compose restart

composer: ## run composer commands
	docker compose run --rm -it php composer $(filter-out $@,$(MAKECMDGOALS))
%:

tinker: ## artisan tinker
	docker compose run --rm php php artisan tinker

.PHONY: artisan
artisan: ## run artisan command
	docker compose run --rm php php artisan $(filter-out $@,$(MAKECMDGOALS))
%:
	@:

npm: ## run npm command
	docker compose run --rm php npm $(filter-out $@,$(MAKECMDGOALS))
%:
	@:

migration: ## make a new migration
	docker compose run --rm php php artisan make:migration $(filter-out $@,$(MAKECMDGOALS))
%:
	@:

migrate: ## run artisan migrate
	docker compose run --rm php php artisan migrate

horizon: ## run horizon
	docker compose run --rm php php artisan horizon

install-laravel: ## Download source Laravel and update .env file
	@if [ -d "./app" ]; then \
		echo "project already exists."; \
	else \
		chmod +x ./docker-repo/install_laravel.sh;\
		./docker-repo/install_laravel.sh;\
		chown -R $(USER):$(GROUP) .;\
		rm -rf src;\
	fi

install: ### init project
	./fix-permissions.sh;\
	cp .env.example .env;\
    cp .env.testing.example .env.testing;\
    make pint-to-git;\
    composer run dev;\

pint-to-git: ## run pint and add modified files to git
	@if [ -d "./.git" ]; then \
		chmod +x ./docker-repo/scripts/setup.sh;\
		./docker-repo/scripts/setup.sh;\
	fi

format: ## format codes with pint
	docker compose run -T --rm php ./vendor/bin/pint --dirty

format-all: ## format codes with pint
	docker compose run -T --rm php ./vendor/bin/pint

test: ## run tests
	docker compose run --rm php php artisan test

# makefile help
help:
	@echo "usage: make [command]"
	@echo ""
	@echo "available commands:"
	@sed \
    		-e '/^[a-zA-Z0-9_\-]*:.*##/!d' \
    		-e 's/:.*##\s*/:/' \
    		-e 's/^\(.\+\):\(.*\)/$(shell tput setaf 6)\1$(shell tput sgr0):\2/' \
    		$(MAKEFILE_LIST) | column -c2 -t -s :
