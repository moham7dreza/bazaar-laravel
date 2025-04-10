# Bazaar App Made With Laravel
<div style="display:flex;flex-direction: column;gap: 1rem;">
    <div>Root</div>
    <img style="margin: auto;" src="public/img/backend-services.png" width="810" height="407" alt="backend-services">
    <div style="margin: 0.3rem;">Admin</div>
    <img style="margin: auto;" src="public/img/filament.png" width="810" height="407" alt="filament">
</div>

### HELP
1. search `runtime` commands with `make` (if you not use docker see `php` prefix commands)
2. search `artisan` commands with `php artisan find` and use --exact argument for exact search
3. search `laravel document topics` with `php artisan docs`

### Setup
1. run `sh fix-permissions.sh` for fix project directory access
2. apply required changes in env files (`MYSQL`, `REDIS`, `MONGO`, ...)
3. run `composer run dev` to an init project and start servers
4. for use `OCTANE` with nginx you need to configure it from [doc](https://laravel.com/docs/12.x/octane#serving-your-application-via-nginx)
5. if you use `herd` goto http://bazaar-laravel.test
6. `admin` user credentials: admin@admin.com, password
7. activate your idea's `laravel pint inspection`
8. fill pusher credentials in .env for use `chatify`
9. you are up, `explore` and have `fun`

### Docker
1. run `make build` to build docker images
2. run `make composer run dev` to init project
3. run `make composer testpf` to create test databases and run tests parallel
4. run `make horizon` to start horizon

### Testing
1. apply required changes in .env.testing file
2. run `composer testpf` for create test databases and run tests parallel
3. if you set up `coverage` engine like Xdebug, you can get coverage report

### Composer Commands
1. `composer ide-helper` - generate IDE helper files
2. `composer reload` - `git pull`, install all dependencies, clear all cache, filament asset updates, migrate and npm install and build
3. `composer cache` - cache system views, events, routes, modules and filament assets
4. `composer clean` - clear all cache
5. `composer deep-clean` - clear cache and data from database and storage
6. `composer testp` - run tests parallel
7. `composer testpf` - recreate test databases and run tests parallel
8. `composer dev` - run `composer reload`, `composer ide-helper`, `composer start`
9. `composer prod` - run `git pull`, install no dev dependencies, clear all cache, run migrations, `composer cache`, `vite build`, `composer start` 
10. `composer start` - fire all servers concurrently (`QUEUE`,`HORIZON`,`REVERB`,`OCTANE`,`VITE`,`SCHEDULE`,`PULSE`,`NEXT`)
11. `composer serve` - fire all servers concurrently (`SERVER`,`QUEUE`,`VITE`,`NEXT`)
12. `composer pint` - run PHP code style fixer
13. `composer stop` - stop all servers
14. `composer dbfresh` - drop and recreate main and test databases

## Tasks
1. refactor image upload operations in controllers
2. define Repositories for important actions
3. complete end-to-end tests for api routes
4. complete enums for status, types and more
5. cron jobs for scheduled tasks
6. fix gates for tools (horizon panel and more)
7. fix global latest scope for models
