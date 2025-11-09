#!make

.DEFAULT_GOAL := search
.PHONY: help fix-permissions setup build ps up down down-volumes restart \
        composer tinker artisan npm migration migrate horizon install-laravel \
        format format-all test next-init next-dev install ide \
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
search: ## Search for a command
	php artisan make:run

help: ## Show this help menu
	@printf "${COLOR_CYAN}Usage:${COLOR_RESET}\n  make [command]\n\n${COLOR_CYAN}Available commands:${COLOR_RESET}\n"
	@awk -F ':.*##' '/^[a-zA-Z0-9_%-]+:.*##/ {printf "  ${COLOR_GREEN}%-25s${COLOR_RESET}%s\n", $$1, $$2}' $(MAKEFILE_LIST) | sort

## Linux
fix-permissions: ## Fix project directory permissions
	@printf "${COLOR_BLUE}▶ Fixing file and directory permissions...${COLOR_RESET}\n"
	@sudo chown -R $(USER):$(USER) .
	@sudo find . -type d \( -name "vendor" -o -name "node_modules" \) -prune -o -type f -exec chmod 664 {} \;
	@sudo find . -type d \( -name "vendor" -o -name "node_modules" \) -prune -o -type d -exec chmod 775 {} \;
	@sudo chgrp -R $(USER) storage bootstrap/cache
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
	@sudo systemctl reload php8.4-fpm
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

format: ## Format changed files with pint
	$(PHP_PINT) --dirty

format-all: ## Format all files with pint
	$(PHP_PINT)

test: ## Run tests
	$(PHP_ARTISAN) test

## Next.js
next-init: ## Initialize Next.js project
	cd /var/www/bazaar-next && npm run init

next-reload: ## pull, install and run Next.js dev server
	cd /var/www/bazaar-next && npm run reload

next-dev: ## Run Next.js dev server
	cd /var/www/bazaar-next && npm run dev

## PHP
install: ## Initialize project
	make fix-permissions
	make setup
	sudo cp .env.example .env
	sudo cp .env.testing.example .env.testing
	make githooks
	make dev

ide: ## Generate IDE helper files
	php artisan ide-helper:generate
	php artisan ide-helper:models --nowrite
	php artisan ide-helper:meta
	php artisan ide-helper:eloquent

dbgrate: ## migrate databases
	php artisan migrate --force
	php artisan migrate --force --env=testing

dbback: ## migrate:rollback databases
	php artisan migrate:rollback --force
	php artisan migrate:rollback --force --env=testing

dbfresh: ## Recreate databases
	php artisan migrate:fresh --force --seed
	php artisan migrate:fresh --force --env=testing

stop: ## Stop all servers
	php artisan octane:stop
	php artisan reverb:restart
	php artisan queue:restart
	php artisan pulse:restart
	php artisan horizon:terminate

testr: ## Run tests in random order
	php artisan config:clear --ansi
	php artisan migrate --force --env=testing
	php artisan test --profile --compact --order-by random

testrf: ## Recreate test db and run tests in random order
	php artisan config:clear --ansi
	php artisan migrate:fresh --force --env=testing
	php artisan test --profile --compact --order-by random

testp: ## Run tests in parallel
	php artisan config:clear --ansi
	php artisan migrate --force --env=testing
	php artisan test --parallel

testpf: ## Recreate test DB and run parallel tests
	php artisan config:clear --ansi
	php artisan migrate --force --env=testing
	php artisan test --parallel --recreate-databases

testcov: ## Generate code coverage report
	php artisan config:clear --ansi
	php artisan migrate --force --env=testing
	php artisan test --coverage --compact --min=30 --coverage-clover=tests/coverage@tests.xml

typecov: ## Generate type coverage report
	php artisan config:clear --ansi
	php artisan migrate --force --env=testing
	php artisan test --type-coverage --compact --min=94 --type-coverage-json=tests/type-coverage@tests.json

testls: ## list tests
	php artisan test --list-tests

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

pintd: ## Run PHP code style fixer to only modify the files that have uncommitted changes
	vendor/bin/pint --dirty --parallel

pintt: ## Run PHP code style fixer to simply inspect your code for style errors
	vendor/bin/pint --test --parallel

pint: ## Run PHP code style fixer
	vendor/bin/pint --repair --parallel

start: ## Start all development servers
	@npx concurrently -k -n "QUEUE,HORIZON,REVERB,OCTANE,VITE,SCHEDULE,PULSE,NEXT,LOGGING,NIGHTWATCH" \
		-c "green,blue,magenta,cyan,yellow,red,gray,black,white,green" \
		"php artisan queue:listen" \
		"php artisan horizon" \
		"php artisan reverb:start --debug" \
		"php artisan octane:start --watch --port=9000" \
		"npm run dev" \
		"php artisan schedule:work" \
		"php artisan pulse:work" \
		"make next-dev" \
        "php artisan pail --timeout=86400" \
        "php artisan nightwatch:agent"

serve: ## Start basic servers
	@npx concurrently -k -n "QUEUE,HORIZON,REVERB,SERVER,VITE,SCHEDULE,PULSE,NEXT,LOGGING,NIGHTWATCH" \
		-c "green,blue,magenta,cyan,yellow,red,gray,black,white,green" \
		"php artisan queue:listen" \
		"php artisan horizon" \
		"php artisan reverb:start --debug" \
		"php artisan serve --port=9000" \
		"npm run dev" \
		"php artisan schedule:run-cronless" \
		"php artisan pulse:work" \
		"make next-dev" \
		"php artisan pail --timeout=86400" \
		"php artisan nightwatch:agent"

reload: ## Update and refresh application
	git pull
	composer install
	php artisan down --refresh=15
	make clean
	php artisan responsecache:clear
	php artisan modules:sync
	php artisan filament:upgrade
	php artisan themes:upgrade
	php artisan migrate --force --seed
	php artisan schedule-monitor:sync
	npm install && npm run build
	php artisan schedule:run
	php artisan backup:list
	php artisan scramble:analyze
	make ide
	php artisan up

dev: ## Full development setup
	make reload
	make checkup
	make testr
	make next-reload
	make start

prod: ## Production deployment
	git pull
	composer install --optimize-autoloader --no-dev
	make clean
	php artisan migrate --graceful --ansi --force
	make cache
	npm install && npm run build
	make start

git-clean: ## prune unused files and compress files to reduce repo size
	git gc --prune=now --aggressive

git-hooks: ## set git hooks path to custom .githooks dir
	sudo chmod +x .githooks
	git config core.hooksPath .githooks

git-alias: ## add aliases to git
	git config --global alias.st status
	git config --global alias.co checkout
	git config --global alias.br branch
	git config --global alias.lg "log --oneline --graph --all --decorate"

git-user:
	git config --global user.name "Mohamadreza Rezaei"
	git config --global user.email "me.moham6dreza@gmail.com"
	git config --list

serve-ip: find-ip ## serve project in local network
	@echo "Starting Laravel development server on http://$(IP):8080"
	@php -S $(IP):8080 -t public

find-ip: ## Find local IP address
	$(eval IP := $(shell \
		if command -v ip >/dev/null; then \
			ip route get 1 | awk '{print $$7}' | head -1; \
		elif command -v ifconfig >/dev/null; then \
			ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1' | head -1; \
		else \
			echo "127.0.0.1"; \
		fi \
	))
	@if [ -z "$(IP)" ]; then \
		echo "Could not detect IP address, falling back to 127.0.0.1"; \
		$(eval IP := 127.0.0.1) \
	fi

checks: ## Run fearless refactoring, it does a lot of smart checks to find certain errors.
	php artisan check:views
	php artisan check:routes
	#php artisan check:psr4
	#php artisan check:imports
	php artisan check:stringy_classes
	php artisan check:dd
	php artisan check:bad_practices
	php artisan check:compact
	php artisan check:blade_queries
	php artisan check:action_comments
	#php artisan check:extract_blades
	php artisan pp:route
	php artisan check:generate
	#php artisan check:endif
	php artisan check:events
	#php artisan check:gates
	php artisan check:dynamic_where
	php artisan check:aliases
	#php artisan check:dead_controllers
	#php artisan check:generic_docblocks
	php artisan enforce:helper_functions
	#php artisan list:models

phpstan: ## Run phpstan analysis
	vendor/bin/phpstan analyse --memory-limit=2G

phpstang: ## Run phpstan analysis and generate baseline
	vendor/bin/phpstan analyse --memory-limit=2G --generate-baseline

rectort: ## Run rector analysis
	vendor/bin/rector process --dry-run

rector: ## Run rector analysis and change files
	vendor/bin/rector

checkup: ## Run necessary tools to check code and code style
	make pintt
	# make checks
	make rectort
	# make phpstan
	make migration-linter

route-ls-v: ## Show list of routes that are registered by packages
	php artisan route:list --only-vendor

setup-worker: ## Configure Supervisor for Laravel queue worker
	@printf "${COLOR_BLUE}▶ Starting Laravel worker setup...${COLOR_RESET}\n"
	@printf '%s\n' '[program:laravel-worker]' \
	'process_name=%(program_name)s_%(process_num)02d' \
	'command=php /var/www/bazaar-laravel/artisan queue:work redis --sleep=3 --tries=3 --max-time=86400' \
	'autostart=true' \
	'autorestart=true' \
	'stopasgroup=true' \
	'killasgroup=true' \
	'user=www-data' \
	'numprocs=8' \
	'redirect_stderr=true' \
	'stdout_logfile=/var/www/bazaar-laravel/storage/logs/worker.log' \
	'stopwaitsecs=3600' | sudo tee /etc/supervisor/conf.d/laravel-worker.conf >/dev/null

	@sudo supervisorctl reread >/dev/null
	@sudo supervisorctl update >/dev/null
	@if sudo supervisorctl status laravel-worker:* | grep -q RUNNING; then \
		printf "${COLOR_YELLOW}✓ Laravel worker is already running${COLOR_RESET}\n"; \
		sudo supervisorctl restart laravel-worker:* >/dev/null; \
		printf "${COLOR_GREEN}✓ Laravel worker restarted${COLOR_RESET}\n"; \
	else \
		sudo supervisorctl start laravel-worker:* >/dev/null; \
		printf "${COLOR_GREEN}✓ Laravel worker started${COLOR_RESET}\n"; \
	fi
	@printf "${COLOR_GREEN}✓ Laravel worker setup completed!${COLOR_RESET}\n"

setup-horizon: ## Configure Supervisor for Laravel horizon
	@printf "${COLOR_BLUE}▶ Starting Laravel horizon setup...${COLOR_RESET}\n"
	@printf '%s\n' '[program:horizon]' \
	'process_name=%(program_name)s_%(process_num)02d' \
	'command=php /var/www/bazaar-laravel/artisan horizon' \
	'autostart=true' \
	'autorestart=true' \
	'user=www-data' \
	'redirect_stderr=true' \
	'stdout_logfile=/var/www/bazaar-laravel/storage/logs/horizon.log' \
	'stopwaitsecs=3600' | sudo tee /etc/supervisor/conf.d/horizon.conf >/dev/null

	@sudo supervisorctl reread >/dev/null
	@sudo supervisorctl update >/dev/null
	@if sudo supervisorctl status horizon | grep -q RUNNING; then \
		printf "${COLOR_YELLOW}✓ Laravel horizon is already running${COLOR_RESET}\n"; \
		sudo supervisorctl restart horizon >/dev/null; \
		printf "${COLOR_GREEN}✓ Laravel horizon restarted${COLOR_RESET}\n"; \
	else \
		sudo supervisorctl start horizon >/dev/null; \
		printf "${COLOR_GREEN}✓ Laravel horizon started${COLOR_RESET}\n"; \
	fi
	@printf "${COLOR_GREEN}✓ Laravel horizon setup completed!${COLOR_RESET}\n"

db-telescope: ## Run Telescope DB migrations
	php artisan migrate --database=telescope --path=vendor/laravel/telescope/database/migrations --force

php-extensions:
	sudo apt install php8.4-{dev,pcov,xdebug,sqlite3,cli,soap,fpm,xml,curl,cgi,mysql,mysqlnd,gd,bz2,ldap,pgsql,opcache,zip,intl,common,bcmath,imagick,xmlrpc,readline,memcached,redis,mbstring,apcu,xml,dom,memcache,mongodb}

phpres:
	sudo systemctl reload nginx
	sudo systemctl reload php8.4-fpm

permissions:
	sudo chmod -R 777 storage

health:
	composer du
	php artisan route:list
	php artisan test

fila-up:
	vendor/bin/filament-v4

migration-linter:
	php artisan migrate:lint --generate-baseline

ports:
	sudo fuser -k 3000/tcp && fuser -k 9000/tcp && fuser -k 2407/tcp
