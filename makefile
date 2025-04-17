#!make

default: help

setup: ## (LINUX) configure Nginx for bazaar.local
	@echo "Starting bazaar.local setup..."
	@echo ""

	# Step 1: Copy nginx.conf
	@echo "1. Copying nginx.conf to bazaar..."
	@sudo cp ./nginx.conf /etc/nginx/sites-available/bazaar
	@echo "✅ Copy completed"
	@echo ""

	# Step 2: Create symbolic link
	@echo "2. Creating symbolic link in sites-enabled..."
	@sudo ln -sf /etc/nginx/sites-available/bazaar /etc/nginx/sites-enabled/
	@echo "✅ Symbolic link created"
	@echo ""

	# Step 3: Test Nginx configuration
	@echo "3. Testing Nginx configuration..."
	@sudo nginx -t
	@echo "✅ Nginx configuration test passed"
	@echo ""

	# Step 4: Reload Nginx
	@echo "4. Reloading Nginx..."
	@sudo systemctl reload nginx
	@echo "✅ Nginx reloaded"
	@echo ""

	# Step 5: Reload PHP-FPM
	@echo "5. Reloading PHP 8.3 FPM..."
	@sudo systemctl reload php8.3-fpm
	@echo "✅ PHP 8.3 FPM reloaded"
	@echo ""

	# Step 6: Update /etc/hosts
	@echo "6. Updating /etc/hosts..."
	@if ! grep -q "bazaar.local" /etc/hosts; then \
		sudo sed -i '1s/^/127.0.0.1 bazaar.local\n/' /etc/hosts; \
		echo "✅ Added bazaar.local to /etc/hosts"; \
	else \
		echo "ℹ️ bazaar.local already exists in /etc/hosts"; \
	fi
	@echo ""

	@echo "🎉 bazaar.local setup completed successfully!"

build: ## (DOCKER) run docker compose build
	docker compose build

ps: ## (DOCKER) docker compose ps
	docker compose ps

up: ## (DOCKER) docker compose up
	docker compose up -d

down: ## (DOCKER) docker compose down
	docker compose down

down-volumes: ## (DOCKER) docker compose down with volumes
	docker compose down --volumes

restart: ## (DOCKER) docker compose restart
	docker compose restart

composer: ## (DOCKER) run composer commands
	docker compose run --rm -it php composer $(filter-out $@,$(MAKECMDGOALS))
%:

tinker: ## (DOCKER) artisan tinker
	docker compose run --rm php php artisan tinker

.PHONY: artisan
artisan: ## (DOCKER) run artisan command
	docker compose run --rm php php artisan $(filter-out $@,$(MAKECMDGOALS))
%:
	@:

npm: ## (DOCKER) run npm command
	docker compose run --rm php npm $(filter-out $@,$(MAKECMDGOALS))
%:
	@:

migration: ## (DOCKER) make a new migration
	docker compose run --rm php php artisan make:migration $(filter-out $@,$(MAKECMDGOALS))
%:
	@:

migrate: ## (DOCKER) run artisan migrate
	docker compose run --rm php php artisan migrate

horizon: ## (DOCKER) run horizon
	docker compose run --rm php php artisan horizon

install-laravel: ## (DOCKER) Download source Laravel and update .env file
	@if [ -d "./app" ]; then \
		echo "project already exists."; \
	else \
		chmod +x ./docker-repo/install_laravel.sh;\
		./docker-repo/install_laravel.sh;\
		chown -R $(USER):$(GROUP) .;\
		rm -rf src;\
	fi

pint-to-git: ## (DOCKER) run pint and add modified files to git
	@if [ -d "./.git" ]; then \
		chmod +x ./docker-repo/scripts/setup.sh;\
		./docker-repo/scripts/setup.sh;\
	fi

format: ## (DOCKER) format codes with pint
	docker compose run -T --rm php ./vendor/bin/pint --dirty

format-all: ## (DOCKER) format codes with pint
	docker compose run -T --rm php ./vendor/bin/pint

test: ## (DOCKER) run tests
	docker compose run --rm php php artisan test

next-init: ## (NEXT) init project
	cd /var/www/bazaar-next && ./install.sh; \

next-dev: ## (NEXT) run dev
	cd /var/www/bazaar-next && npm run reload; \

install: ## (PHP) init project
	./fix-permissions.sh;\
	./setup.sh; \
	sudo cp .env.example .env;\
    sudo cp .env.testing.example .env.testing;\
    make dev;\

ide: ## (PHP) generate IDE helper files
	php artisan ide-helper:generate;\
	php artisan ide-helper:models --nowrite;\
	php artisan ide-helper:meta;\
	php artisan ide-helper:eloquent;\

dbfresh: ## (PHP) drop and recreate main and test databases
	php artisan migrate:fresh --force --seed;\
	php artisan migrate:fresh --force --env=testing;\

stop: ## (PHP) stop servers
	php artisan octane:stop;\
	php artisan reverb:restart;\
	php artisan queue:restart;\
	php artisan pulse:restart;\
	php artisan horizon:terminate;\

testp: ## (PHP) run tests parallel
	php artisan migrate --force --env=testing;\
    php artisan test --parallel;\

testpf: ## (PHP) recreact tests databases and run tests parallel
	php artisan migrate --force --env=testing;\
    php artisan test --parallel --recreate-databases;\

clean: ## (PHP) cache all system clear
	php artisan clear-compiled;\
	php artisan optimize:clear;\
	php artisan modules:clear;\
	php artisan filament:optimize-clear;\
	php artisan schedule:clear-cache;\
	php artisan permission:cache-reset;\
	php artisan debugbar:clear;\

deepclean: ## (PHP) clear cache and data from database and storage
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

cache: ## (PHP) cache system views, events, routes, modules and filament assets
	php artisan optimize;\
	php artisan modules:cache;\
	php artisan filament:optimize;\
	php artisan settings:discover;\

pint: ## (PHP) run run PHP code style fixer and show tested files
	./vendor/bin/pint --test; \

start: ## (PHP) fire all servers concurrently (`QUEUE`,`HORIZON`,`REVERB`,`OCTANE`,`VITE`,`SCHEDULE`,`PULSE`,`NEXT`)
	npx concurrently -k -n "QUEUE,HORIZON,REVERB,OCTANE,VITE,SCHEDULE,PULSE,NEXT" -c "green,blue,magenta,cyan,yellow,red,gray,black" "php artisan queue:work" "php artisan horizon" "php artisan reverb:start --debug" "php artisan octane:start --port=9000" "npm run dev" "php artisan schedule:work" "php artisan pulse:work" "make next-dev"; \

serve: ## (PHP) fire all servers concurrently (`SERVER`,`QUEUE`,`VITE`,`NEXT`)
	npx concurrently -k -n "QUEUE,HORIZON,REVERB,SERVER,VITE,SCHEDULE,PULSE,NEXT" -c "green,blue,magenta,cyan,yellow,red,gray,black" "php artisan queue:listen --tries=1" "php artisan horizon" "php artisan reverb:start --debug" "php artisan serve --port=9000" "npm run dev" "php artisan schedule:work" "php artisan pulse:work" "make next-dev"; \

reload: ## (PHP) `git pull`, install all dependencies, clear all cache, filament asset updates, migrate and npm install and build
	git pull; \
	composer install; \
	php artisan down; \
	make clean; \
	php artisan modules:sync; \
	php artisan filament:upgrade; \
	php artisan themes:upgrade; \
	php artisan storage:link; \
	php artisan migrate --force --seed; \
	php artisan schedule-monitor:sync; \
	npm install && npm run build; \
	php artisan schedule:run; \
	php artisan backup:run; \
	make pint; \
	php artisan scramble:analyze; \
	php artisan up; \

dev: ## (PHP) run `make reload`, `make ide`, `make start`
	make reload; \
	make ide; \
	make start; \

prod: ## (PHP) run `git pull`, install no dev dependencies, clear all cache, run migrations, `make cache`, `vite build`, `make start`
	git pull; \
	composer install --optimize-autoloader --no-dev; \
	make clean; \
	php artisan migrate --graceful --ansi --force; \
	make cache; \
	npm install && npm run build; \
	make start; \

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
