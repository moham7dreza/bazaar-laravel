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

# Check if php container exists in compose stack and set ENTRYPOINT
PHP_CONTAINER := $(shell docker compose ps -q php 2>/dev/null)
ENTRYPOINT =
ifneq ($(PHP_CONTAINER),)
    ENTRYPOINT = docker compose exec php
else
    $(info Compose stack is not running, running commands directly on host)
endif

# Common variables
DOCKER_COMPOSE = docker compose
PHP_ARTISAN = $(DOCKER_COMPOSE) run --rm php ${ENTRYPOINT} php artisan
PHP_COMPOSER = $(DOCKER_COMPOSE) run --rm -it php composer
PHP_NPM = $(DOCKER_COMPOSE) run --rm php npm
PHP_PINT = $(DOCKER_COMPOSE) run -T --rm php ./vendor/bin/pint
PHP_VERSION=php8.4

# --------------------------------------------------------------------------
# OS Detection
# --------------------------------------------------------------------------
UNAME_S := $(shell uname -s)

# Set OS-specific variables
ifeq ($(UNAME_S),Linux)
    OS = linux
    NEXTJS_PATH = /var/www/bazaar-next
    CD_CMD = cd
    EXEC_CMD =
else ifeq ($(UNAME_S),Darwin)
    OS = macos
    NEXTJS_PATH = /Users/mohammadreza/Documents/GitHub/bazaar-next
    CD_CMD = cd
    EXEC_CMD =
else
    OS = windows
    # Windows paths - adjust based on your setup
    ifneq (,$(findstring Microsoft,$(shell uname -r)))
        # WSL2
        NEXTJS_PATH = /var/www/bazaar-next
        CD_CMD = cd
        EXEC_CMD =
    else ifneq (,$(findstring MINGW,$(UNAME_S)))
        # Git Bash / MinGW
        NEXTJS_PATH = /c/var/www/bazaar-next
        CD_CMD = cd
        EXEC_CMD =
    else
        # Native Windows CMD
        NEXTJS_PATH = C:\var\www\bazaar-next
        CD_CMD = cd /d
        EXEC_CMD = cmd /C
    endif
endif

os-info: ## Show OS detection info
	@echo "OS: $(OS)"
	@echo "UNAME_S: $(UNAME_S)"
	@echo "Next.js Path: $(NEXTJS_PATH)"
	@echo "CD Command: $(CD_CMD)"
	@echo "Exec Command: $(EXEC_CMD)"

# --------------------------------------------------------------------------
# Make menus
# --------------------------------------------------------------------------
search: ## Search for a command
	${ENTRYPOINT} php artisan make:run

help: ## Show this help menu
	@printf "${COLOR_CYAN}Usage:${COLOR_RESET}\n  make [command]\n\n${COLOR_CYAN}Available commands:${COLOR_RESET}\n"
	@awk -F ':.*##' '/^[a-zA-Z0-9_%-]+:.*##/ {printf "  ${COLOR_GREEN}%-25s${COLOR_RESET}%s\n", $$1, $$2}' $(MAKEFILE_LIST) | sort

# --------------------------------------------------------------------------
# Docker
# --------------------------------------------------------------------------
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

# --------------------------------------------------------------------------
# Next js
# --------------------------------------------------------------------------
next-init: ## Initialize Next.js project
	@echo "Running on $(OS)"
	$(CD_CMD) "$(NEXTJS_PATH)" && $(EXEC_CMD) npm run init

next-reload: ## pull, install and run Next.js dev server
	@echo "Running on $(OS)"
	$(CD_CMD) "$(NEXTJS_PATH)" && $(EXEC_CMD) npm run reload

next-dev: ## Run Next.js dev server
	@echo "Running on $(OS)"
	$(CD_CMD) "$(NEXTJS_PATH)" && $(EXEC_CMD) npm run dev

# --------------------------------------------------------------------------
# Database
# --------------------------------------------------------------------------
db-grate: ## migrate databases
	${ENTRYPOINT} php artisan migrate --force
	${ENTRYPOINT} php artisan migrate --force --env=testing

db-back: ## migrate:rollback databases
	${ENTRYPOINT} php artisan migrate:rollback --force
	${ENTRYPOINT} php artisan migrate:rollback --force --env=testing

db-fresh: ## Recreate databases
	${ENTRYPOINT} php artisan migrate:fresh --force --seed
	${ENTRYPOINT} php artisan migrate:fresh --force --env=testing

db-telescope: ## Run Telescope DB migrations
	${ENTRYPOINT} php artisan migrate --database=telescope --path=vendor/laravel/telescope/database/migrations --force

# --------------------------------------------------------------------------
# Tests
# --------------------------------------------------------------------------

test-r: ## Run tests in random order
	${ENTRYPOINT} php artisan config:clear --ansi
	${ENTRYPOINT} php artisan migrate --force --env=testing
	${ENTRYPOINT} php artisan test --profile --compact --order-by random

test-rf: ## Recreate test db and run tests in random order
	${ENTRYPOINT} php artisan config:clear --ansi
	${ENTRYPOINT} php artisan migrate:fresh --force --env=testing
	${ENTRYPOINT} php artisan test --profile --compact --order-by random

test-p: ## Run tests in parallel
	${ENTRYPOINT} php artisan config:clear --ansi
	${ENTRYPOINT} php artisan migrate --force --env=testing
	${ENTRYPOINT} php artisan test --parallel

test-pf: ## Recreate test DB and run parallel tests
	${ENTRYPOINT} php artisan config:clear --ansi
	${ENTRYPOINT} php artisan migrate --force --env=testing
	${ENTRYPOINT} php artisan test --parallel --recreate-databases

test-cov: ## Generate code coverage report
	${ENTRYPOINT} php artisan config:clear --ansi
	${ENTRYPOINT} php artisan migrate --force --env=testing
	${ENTRYPOINT} php artisan test --coverage --compact --min=30 --coverage-clover=tests/coverage@tests.xml

test-type-cov: ## Generate type coverage report
	${ENTRYPOINT} php artisan config:clear --ansi
	${ENTRYPOINT} php artisan migrate --force --env=testing
	${ENTRYPOINT} php artisan test --type-coverage --compact --min=94 --type-coverage-json=tests/type-coverage@tests.json

test-ls: ## list tests
	${ENTRYPOINT} php artisan test --list-tests

# --------------------------------------------------------------------------
# Clear
# --------------------------------------------------------------------------

clean: ## Clear all caches
	${ENTRYPOINT} php artisan clear-compiled
	${ENTRYPOINT} php artisan optimize:clear
	${ENTRYPOINT} php artisan modules:clear
	${ENTRYPOINT} php artisan filament:optimize-clear
	${ENTRYPOINT} php artisan schedule:clear-cache
	${ENTRYPOINT} php artisan permission:cache-reset
	${ENTRYPOINT} php artisan debugbar:clear

deep-clean: ## Deep clean application
	${ENTRYPOINT} php artisan activitylog:clean
	${ENTRYPOINT} php artisan mail:prune
	${ENTRYPOINT} php artisan telescope:clear
	${ENTRYPOINT} php artisan telescope:prune
	${ENTRYPOINT} php artisan horizon:clear
	${ENTRYPOINT} php artisan horizon:clear-metrics
	${ENTRYPOINT} php artisan pulse:clear
	${ENTRYPOINT} php artisan queue:clear
	${ENTRYPOINT} php artisan settings:clear-cache
	${ENTRYPOINT} php artisan settings:clear-discovered
	${ENTRYPOINT} php artisan auth:clear-resets
	${ENTRYPOINT} php artisan backup:clean
	${ENTRYPOINT} php artisan cache:prune-stale-tags
	${ENTRYPOINT} php artisan filament-excel:prune
	${ENTRYPOINT} php artisan sanctum:prune-expired

cache: ## Cache system files
	${ENTRYPOINT} php artisan optimize
	${ENTRYPOINT} php artisan modules:cache
	${ENTRYPOINT} php artisan filament:optimize
	${ENTRYPOINT} php artisan settings:discover

# --------------------------------------------------------------------------
# Pint
# --------------------------------------------------------------------------

pint-dirty: ## Run PHP code style fixer to only modify the files that have uncommitted changes
	vendor/bin/pint --dirty --parallel

pint-test: ## Run PHP code style fixer to simply inspect your code for style errors
	vendor/bin/pint --test --parallel

pint: ## Run PHP code style fixer
	vendor/bin/pint --repair --parallel

# --------------------------------------------------------------------------
# Serve
# --------------------------------------------------------------------------

start: ## Start all development servers
	@npx concurrently -k -n "QUEUE,HORIZON,REVERB,OCTANE,VITE,SCHEDULE,PULSE,NEXT,LOGGING,NIGHTWATCH" \
		-c "green,blue,magenta,cyan,yellow,red,gray,black,white,green" \
		"${ENTRYPOINT} php artisan queue:listen" \
		"${ENTRYPOINT} php artisan horizon" \
		"${ENTRYPOINT} php artisan reverb:start --debug" \
		"${ENTRYPOINT} php artisan octane:start --watch --port=9000" \
		"npm run dev" \
		"${ENTRYPOINT} php artisan schedule:work" \
		"${ENTRYPOINT} php artisan pulse:work" \
		"make next-dev" \
        "${ENTRYPOINT} php artisan pail --timeout=86400" \
        "${ENTRYPOINT} php artisan nightwatch:agent"

serve: ## Start basic servers
	@npx concurrently -k -n "QUEUE,HORIZON,REVERB,SERVER,VITE,SCHEDULE,PULSE,NEXT,LOGGING,NIGHTWATCH" \
		-c "green,blue,magenta,cyan,yellow,red,gray,black,white,green" \
		"${ENTRYPOINT} php artisan queue:listen" \
		"${ENTRYPOINT} php artisan horizon" \
		"${ENTRYPOINT} php artisan reverb:start --debug" \
		"${ENTRYPOINT} php artisan serve --port=9000" \
		"npm run dev" \
		"${ENTRYPOINT} php artisan schedule:run-cronless" \
		"${ENTRYPOINT} php artisan pulse:work" \
		"make next-dev" \
		"${ENTRYPOINT} php artisan pail --timeout=86400" \
		"${ENTRYPOINT} php artisan nightwatch:agent"

stop: ## Stop all servers
	${ENTRYPOINT} php artisan octane:stop
	${ENTRYPOINT} php artisan reverb:restart
	${ENTRYPOINT} php artisan queue:restart
	${ENTRYPOINT} php artisan pulse:restart
	${ENTRYPOINT} php artisan horizon:terminate

# --------------------------------------------------------------------------
# Setup
# --------------------------------------------------------------------------

install: ## Initialize project
	make fix-permissions
	make setup
	sudo cp .env.example .env
	sudo cp .env.testing.example .env.testing
	make git-hooks
	make dev

ide: ## Generate IDE helper files
	${ENTRYPOINT} php artisan ide-helper:generate
	${ENTRYPOINT} php artisan ide-helper:models --nowrite
	${ENTRYPOINT} php artisan ide-helper:meta
	${ENTRYPOINT} php artisan ide-helper:eloquent

reload: ## Update and refresh application
	git pull
	composer install
	${ENTRYPOINT} php artisan down --refresh=15
	make clean
	${ENTRYPOINT} php artisan responsecache:clear
	${ENTRYPOINT} php artisan modules:sync
	${ENTRYPOINT} php artisan filament:upgrade
	${ENTRYPOINT} php artisan themes:upgrade
	${ENTRYPOINT} php artisan migrate --force --seed
	${ENTRYPOINT} php artisan schedule-monitor:sync
	npm install && npm run build
	${ENTRYPOINT} php artisan schedule:run
	${ENTRYPOINT} php artisan backup:list
	${ENTRYPOINT} php artisan scramble:analyze
	make ide
	${ENTRYPOINT} php artisan up

dev: ## Full development setup
	make reload
	make checkup
	make test-r
	make next-reload
	make start

prod: ## Production deployment
	git pull
	composer install --optimize-autoloader --no-dev
	make clean
	${ENTRYPOINT} php artisan migrate --graceful --ansi --force
	make cache
	npm install && npm run build
	make start

# --------------------------------------------------------------------------
# Git
# --------------------------------------------------------------------------

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

git-blame-ignore:
	git config blame.ignoreRevsFile .git-blame-ignore-revs

# --------------------------------------------------------------------------
# Health
# --------------------------------------------------------------------------

microscope: ## Run fearless refactoring, it does a lot of smart checks to find certain errors.
	${ENTRYPOINT} php artisan check:views
	${ENTRYPOINT} php artisan check:routes
	#${ENTRYPOINT} php artisan check:psr4
	#${ENTRYPOINT} php artisan check:imports
	${ENTRYPOINT} php artisan check:stringy_classes
	${ENTRYPOINT} php artisan check:dd
	${ENTRYPOINT} php artisan check:bad_practices
	${ENTRYPOINT} php artisan check:compact
	${ENTRYPOINT} php artisan check:blade_queries
	${ENTRYPOINT} php artisan check:action_comments
	#${ENTRYPOINT} php artisan check:extract_blades
	${ENTRYPOINT} php artisan pp:route
	${ENTRYPOINT} php artisan check:generate
	#${ENTRYPOINT} php artisan check:endif
	${ENTRYPOINT} php artisan check:events
	#${ENTRYPOINT} php artisan check:gates
	${ENTRYPOINT} php artisan check:dynamic_where
	${ENTRYPOINT} php artisan check:aliases
	#${ENTRYPOINT} php artisan check:dead_controllers
	#${ENTRYPOINT} php artisan check:generic_docblocks
	${ENTRYPOINT} php artisan enforce:helper_functions
	#${ENTRYPOINT} php artisan list:models

app-checkup: ## Run necessary tools to check code and code style
	make pint-test
	# make checks
	make rector-test
	# make phpstan
	make migrate-lint
	make test-p

app-health:
	composer du
	${ENTRYPOINT} php artisan route:list
	make test-r

migrate-lint:
	${ENTRYPOINT} php artisan migrate:lint

migrate-lint-baseline:
	${ENTRYPOINT} php artisan migrate:lint --generate-baseline

# --------------------------------------------------------------------------
# Phpstan
# --------------------------------------------------------------------------

phpstan: ## Run phpstan analysis
	vendor/bin/phpstan analyse --memory-limit=2G

phpstan-baseline: ## Run phpstan analysis and generate baseline
	vendor/bin/phpstan analyse --memory-limit=2G --generate-baseline

rector-test: ## Run rector analysis
	vendor/bin/rector process --dry-run

rector: ## Run rector analysis and change files
	vendor/bin/rector process

# --------------------------------------------------------------------------
# Boost
# --------------------------------------------------------------------------
boost-install:
	${ENTRYPOINT} php artisan boost:mcp

boost-update:
	${ENTRYPOINT} php artisan boost:update --ansi

# --------------------------------------------------------------------------
# Others
# --------------------------------------------------------------------------

upgrade:
	composer update
	npm update

vendor-routes: ## Show list of routes that are registered by packages
	${ENTRYPOINT} php artisan route:list --only-vendor

filament-up:
	vendor/bin/filament-v4

toon:
	${ENTRYPOINT} php artisan toon:convert $(filter-out $@,$(MAKECMDGOALS)) --decode --pretty
%:

post-update-cmd:
	${ENTRYPOINT} php artisan vendor:publish --tag=laravel-assets --ansi --force
	${ENTRYPOINT} php artisan filament:assets
	${ENTRYPOINT} php artisan boost:update --ansi

# --------------------------------------------------------------------------
# Linux
# --------------------------------------------------------------------------
php-extensions:
	sudo apt install ${PHP_VERSION}-{dev,pcov,xdebug,sqlite3,cli,soap,fpm,xml,curl,cgi,mysql,mysqlnd,gd,bz2,ldap,pgsql,opcache,zip,intl,common,bcmath,imagick,xmlrpc,readline,memcached,redis,mbstring,apcu,xml,dom,memcache,mongodb}

php-reload:
	sudo systemctl reload nginx
	sudo systemctl reload ${PHP_VERSION}-fpm

permissions:
	sudo chmod -R 777 storage

ports:
	sudo fuser -k 3000/tcp && fuser -k 9000/tcp && fuser -k 2407/tcp

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
	@sudo systemctl reload ${PHP_VERSION}-fpm
	@if ! grep -q "bazaar.local" /etc/hosts; then \
		sudo sed -i '1s/^/127.0.0.1 bazaar.local\n/' /etc/hosts; \
		printf "${COLOR_GREEN}✓ Added bazaar.local to /etc/hosts${COLOR_RESET}\n"; \
	else \
		printf "${COLOR_YELLOW}ℹ bazaar.local already exists in /etc/hosts${COLOR_RESET}\n"; \
	fi
	@printf "${COLOR_GREEN}✓ bazaar.local setup completed!${COLOR_RESET}\n"

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

# --------------------------------------------------------------------------
# End
# --------------------------------------------------------------------------
