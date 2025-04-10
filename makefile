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

php-install: ### (PHP) init project
	./fix-permissions.sh;\
	sudo cp .env.example .env;\
    sudo cp .env.testing.example .env.testing;\
    make pint-to-git;\
    composer run dev;\

php-ide: ## (PHP) generate IDE helper files
	php artisan ide-helper:generate;\
	php artisan ide-helper:models --nowrite;\
	php artisan ide-helper:meta;\
	php artisan ide-helper:eloquent;\

php-dbfresh: ## (PHP) drop and recreate main and test databases
	php artisan migrate:fresh --force --seed;\
	php artisan migrate:fresh --force --env=testing;\

php-stop: ## (PHP) stop servers
	php artisan octane:stop;\
	php artisan reverb:restart;\
	php artisan queue:restart;\
	php artisan pulse:restart;\
	php artisan horizon:terminate;\

php-testp: ## (PHP) run tests parallel
	php artisan migrate --force --env=testing;\
    php artisan test --parallel;\

php-testpf: ## (PHP) recreact tests databases and run tests parallel
	php artisan migrate --force --env=testing;\
    php artisan test --parallel --recreate-databases;\

php-clean: ## (PHP) cache all system clear
	php artisan clear-compiled;\
	php artisan optimize:clear;\
	php artisan modules:clear;\
	php artisan filament:optimize-clear;\
	php artisan schedule:clear-cache;\
	php artisan permission:cache-reset;\
	php artisan debugbar:clear;\

php-deepclean: ## (PHP) clear cache and data from database and storage
	php artisan activitylog:clean;\
	php artisan mail:prune;\
	php artisan telescope:clear;\
	php artisan telescope:prune;\
	php artisan horizon:clear;\
	php artisan horizon:clear-metrics;\
	php artisan pulse:clear;\
	php artisan queue:clear;\
	php artisan settings:clear-cache;\
	php artisan settings:clear-discovered;\
	php artisan auth:clear-resets;\
	php artisan backup:clean;\
	php artisan cache:prune-stale-tags;\
	php artisan filament-excel:prune;\
	php artisan sanctum:prune-expired;\

php-cache: ## (PHP) cache system views, events, routes, modules and filament assets
	php artisan optimize;\
	php artisan modules:cache;\
	php artisan filament:optimize;\
	php artisan settings:discover;\

php-pint: ## (PHP) run run PHP code style fixer and show tested files
	./vendor/bin/pint --test; \

php-start: ## (PHP) fire all servers concurrently (`QUEUE`,`HORIZON`,`REVERB`,`OCTANE`,`VITE`,`SCHEDULE`,`PULSE`,`NEXT`)
	npx concurrently -k -n "QUEUE,HORIZON,REVERB,OCTANE,VITE,SCHEDULE,PULSE,NEXT" -c "green,blue,magenta,cyan,yellow,red,gray,white" "php artisan queue:work" "php artisan horizon" "php artisan reverb:start --debug" "php artisan octane:start --port=9000" "npm run dev" "php artisan schedule:work" "php artisan pulse:work" "cd /var/www/bazaar-next && npm run dev"; \

php-serve: ## (PHP) fire all servers concurrently (`SERVER`,`QUEUE`,`VITE`,`NEXT`)
	npx concurrently -k -n \"QUEUE,HORIZON,REVERB,SERVER,VITE,SCHEDULE,PULSE,NEXT\" -c \"green,blue,magenta,cyan,yellow,red,gray,white\" \"php artisan queue:listen --tries=1\" \"php artisan horizon\" \"php artisan reverb:start --debug\" \"php artisan serve --port=9000\" \"npm run dev\" \"php artisan schedule:work\" \"php artisan pulse:work\" \"cd /var/www/bazaar-next && npm run dev\"; \

php-reload: ## (PHP) `git pull`, install all dependencies, clear all cache, filament asset updates, migrate and npm install and build
	git pull; \
	composer install; \
	php artisan down; \
	make php-clean; \
	php artisan modules:sync; \
	php artisan filament:upgrade; \
	php artisan themes:upgrade; \
	php artisan storage:link; \
	php artisan migrate --force --seed; \
	php artisan schedule-monitor:sync; \
	npm install && npm run build; \
	php artisan schedule:run; \
	php artisan backup:run; \
	make php-pint; \
	php artisan scramble:analyze; \
	php artisan up; \

php-dev: ## (PHP) run `make php-reload`, `make php-ide`, `make php-start`
	make php-reload; \
	make php-ide; \
	make php-start; \

php-prod: ## (PHP) run `git pull`, install no dev dependencies, clear all cache, run migrations, `make php-cache`, `vite build`, `make php-start`
	git pull; \
	composer install --optimize-autoloader --no-dev; \
	make php-clean; \
	php artisan migrate --graceful --ansi --force; \
	make php-cache; \
	npm install && npm run build; \
	make php-start; \

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
