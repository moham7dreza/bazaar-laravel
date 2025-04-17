#!make

.DEFAULT_GOAL := help
.PHONY: help fix-permissions setup build ps up down down-volumes restart \
        composer tinker artisan npm migration migrate horizon install-laravel \
        pint-to-git format format-all test next-init next-dev install ide \
        dbfresh stop testp testpf clean deepclean cache pint start serve \
        reload dev prod

# Colors
COLOR_RESET = \033[0m
COLOR_GREEN = \033[32m
COLOR_BLUE = \033[34m
COLOR_CYAN = \033[36m
COLOR_YELLOW = \033[33m

# Common variables
DOCKER_COMPOSE = docker compose
PHP_ARTISAN = $(DOCKER_COMPOSE) run --rm php php artisan
PHP_COMPOSER = $(DOCKER_COMPOSE) run --rm -it php composer
PHP_NPM = $(DOCKER_COMPOSE) run --rm php npm
PHP_PINT = $(DOCKER_COMPOSE) run -T --rm php ./vendor/bin/pint

## Project Management
help: ## Show this help menu
	@printf "${COLOR_CYAN}Usage:${COLOR_RESET}\n  make [command]\n\n${COLOR_CYAN}Available commands:${COLOR_RESET}\n"
	@awk -F ':.*##' '/^[a-zA-Z0-9_%-]+:.*##/ {printf "  ${COLOR_GREEN}%-25s${COLOR_RESET}%s\n", $$1, $$2}' $(MAKEFILE_LIST) | sort

## Linux
fix-permissions: ## Fix project directory permissions
	@printf "${COLOR_BLUE}▶ Fixing file and directory permissions...${COLOR_RESET}\n"
	@sudo chown -R $(USER):www-data .
	@sudo find . -type f -exec chmod 664 {} \;
	@sudo find . -type d -exec chmod 775 {} \;
	@sudo chgrp -R www-data storage bootstrap/cache
	@sudo chmod -R ug+rwx storage bootstrap/cache
	@printf "${COLOR_GREEN}✓ All permissions fixed successfully!${COLOR_RESET}\n"

setup: ## Configure Nginx for bazaar.local
	@printf "${COLOR_BLUE}▶ Starting bazaar.local setup...${COLOR_RESET}\n"
	@printf '%s\n' 'map $$http_upgrade $$connection_upgrade {' \
	'    default upgrade;' \
	'    ""      close;' \
	'}' \
	'' \
	'server {' \
	'    listen 80;' \
	'    listen [::]:80;' \
	'    server_name bazaar.local;' \
	'    server_tokens off;' \
	'    root /var/www/bazaar-laravel/public;' \
	'' \
	'    index index.php;' \
	'' \
	'    charset utf-8;' \
	'' \
	'    location /index.php {' \
	'        try_files /not_exists @octane;' \
	'    }' \
	'' \
	'    location / {' \
	'        try_files $$uri $$uri/ @octane;' \
	'    }' \
	'' \
	'    location = /favicon.ico { access_log off; log_not_found off; }' \
	'    location = /robots.txt  { access_log off; log_not_found off; }' \
	'' \
	'    access_log off;' \
	'    error_log  /var/log/nginx/bazaar-error.log error;' \
	'' \
	'    error_page 404 /index.php;' \
	'' \
	'    location @octane {' \
	'        set $$suffix "";' \
	'' \
	'        if ($$uri = /index.php) {' \
	'            set $$suffix ?$$query_string;' \
	'        }' \
	'' \
	'        proxy_http_version 1.1;' \
	'        proxy_set_header Host $$http_host;' \
	'        proxy_set_header Scheme $$scheme;' \
	'        proxy_set_header SERVER_PORT $$server_port;' \
	'        proxy_set_header REMOTE_ADDR $$remote_addr;' \
	'        proxy_set_header X-Forwarded-For $$proxy_add_x_forwarded_for;' \
	'        proxy_set_header Upgrade $$http_upgrade;' \
	'        proxy_set_header Connection $$connection_upgrade;' \
	'' \
	'        proxy_pass http://127.0.0.1:9000$$suffix;' \
	'    }' \
	'}' | sudo tee /etc/nginx/sites-available/bazaar >/dev/null

	@sudo ln -sf /etc/nginx/sites-available/bazaar /etc/nginx/sites-enabled/
	@sudo nginx -t
	@sudo systemctl reload nginx
	@sudo systemctl reload php8.3-fpm
	@if ! grep -q "bazaar.local" /etc/hosts; then \
		sudo sed -i '1s/^/127.0.0.1 bazaar.local\n/' /etc/hosts; \
		printf "${COLOR_GREEN}✓ Added bazaar.local to /etc/hosts${COLOR_RESET}\n"; \
	else \
		printf "${COLOR_YELLOW}ℹ bazaar.local already exists in /etc/hosts${COLOR_RESET}\n"; \
	fi
	@printf "${COLOR_GREEN}✓ bazaar.local setup completed!${COLOR_RESET}\n"

## Docker
build: ## Run docker compose build
	$(DOCKER_COMPOSE) build

ps: ## Show running containers
	$(DOCKER_COMPOSE) ps

up: ## Start containers in detached mode
	$(DOCKER_COMPOSE) up -d

down: ## Stop containers
	$(DOCKER_COMPOSE) down

down-volumes: ## Stop containers and remove volumes
	$(DOCKER_COMPOSE) down --volumes

restart: ## Restart containers
	$(DOCKER_COMPOSE) restart

composer: ## Run composer commands
	$(PHP_COMPOSER) $(filter-out $@,$(MAKECMDGOALS))
%:

tinker: ## Start Artisan tinker
	$(PHP_ARTISAN) tinker

artisan: ## Run Artisan commands
	$(PHP_ARTISAN) $(filter-out $@,$(MAKECMDGOALS))
%:

npm: ## Run npm commands
	$(PHP_NPM) $(filter-out $@,$(MAKECMDGOALS))
%:

migration: ## Create new migration
	$(PHP_ARTISAN) make:migration $(filter-out $@,$(MAKECMDGOALS))
%:

migrate: ## Run migrations
	$(PHP_ARTISAN) migrate

horizon: ## Start Horizon queue
	$(PHP_ARTISAN) horizon

## Development
install-laravel: ## Download Laravel and update .env
	@if [ -d "./app" ]; then \
		printf "${COLOR_YELLOW}ℹ Project already exists.${COLOR_RESET}\n"; \
	else \
		chmod +x ./docker-repo/install_laravel.sh; \
		./docker-repo/install_laravel.sh; \
		chown -R $(USER):$(GROUP) .; \
		rm -rf src; \
	fi

pint-to-git: ## Run pint and add modified files to git
	@if [ -d "./.git" ]; then \
		chmod +x ./docker-repo/scripts/setup.sh; \
		./docker-repo/scripts/setup.sh; \
	fi

format: ## Format changed files with pint
	$(PHP_PINT) --dirty

format-all: ## Format all files with pint
	$(PHP_PINT)

test: ## Run tests
	$(PHP_ARTISAN) test

## Next.js
next-init: ## Initialize Next.js project
	cd /var/www/bazaar-next && ./install.sh

next-dev: ## Run Next.js dev server
	cd /var/www/bazaar-next && npm run reload

## PHP
install: ## Initialize project
	./fix-permissions.sh
	./setup.sh
	sudo cp .env.example .env
	sudo cp .env.testing.example .env.testing
	make dev

ide: ## Generate IDE helper files
	php artisan ide-helper:generate
	php artisan ide-helper:models --nowrite
	php artisan ide-helper:meta
	php artisan ide-helper:eloquent

dbfresh: ## Recreate databases
	php artisan migrate:fresh --force --seed
	php artisan migrate:fresh --force --env=testing

stop: ## Stop all servers
	php artisan octane:stop
	php artisan reverb:restart
	php artisan queue:restart
	php artisan pulse:restart
	php artisan horizon:terminate

testp: ## Run tests in parallel
	php artisan migrate --force --env=testing
	php artisan test --parallel

testpf: ## Recreate test DB and run parallel tests
	php artisan migrate --force --env=testing
	php artisan test --parallel --recreate-databases

clean: ## Clear all caches
	php artisan clear-compiled
	php artisan optimize:clear
	php artisan modules:clear
	php artisan filament:optimize-clear
	php artisan schedule:clear-cache
	php artisan permission:cache-reset
	php artisan debugbar:clear

deepclean: ## Deep clean application
	php artisan activitylog:clean
	php artisan mail:prune
	php artisan telescope:clear
	php artisan telescope:prune
	php artisan horizon:clear
	php artisan horizon:clear-metrics
	php artisan pulse:clear
	php artisan queue:clear
	php artisan settings:clear-cache
	php artisan settings:clear-discovered
	php artisan auth:clear-resets
	php artisan backup:clean
	php artisan cache:prune-stale-tags
	php artisan filament-excel:prune
	php artisan sanctum:prune-expired

cache: ## Cache system files
	php artisan optimize
	php artisan modules:cache
	php artisan filament:optimize
	php artisan settings:discover

pint: ## Run PHP code style fixer
	./vendor/bin/pint --test

start: ## Start all development servers
	npx concurrently -k -n "QUEUE,HORIZON,REVERB,OCTANE,VITE,SCHEDULE,PULSE,NEXT" \
		-c "green,blue,magenta,cyan,yellow,red,gray,black" \
		"php artisan queue:work" \
		"php artisan horizon" \
		"php artisan reverb:start --debug" \
		"php artisan octane:start --port=9000" \
		"npm run dev" \
		"php artisan schedule:work" \
		"php artisan pulse:work" \
		"make next-dev"

serve: ## Start basic servers
	npx concurrently -k -n "QUEUE,HORIZON,REVERB,SERVER,VITE,SCHEDULE,PULSE,NEXT" \
		-c "green,blue,magenta,cyan,yellow,red,gray,black" \
		"php artisan queue:listen --tries=1" \
		"php artisan horizon" \
		"php artisan reverb:start --debug" \
		"php artisan serve --port=9000" \
		"npm run dev" \
		"php artisan schedule:work" \
		"php artisan pulse:work" \
		"make next-dev"

reload: ## Update and refresh application
	git pull
	composer install
	php artisan down
	make clean
	php artisan modules:sync
	php artisan filament:upgrade
	php artisan themes:upgrade
	php artisan migrate --force --seed
	php artisan schedule-monitor:sync
	npm install && npm run build
	php artisan schedule:run
	php artisan backup:run
	make pint
	php artisan scramble:analyze
	php artisan up

dev: ## Full development setup
	make reload
	make ide
	make start

prod: ## Production deployment
	git pull
	composer install --optimize-autoloader --no-dev
	make clean
	php artisan migrate --graceful --ansi --force
	make cache
	npm install && npm run build
	make start
