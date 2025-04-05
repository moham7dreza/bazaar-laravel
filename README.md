# Bazaar App Made With Laravel
<div style="display:flex;flex-direction: column;gap: 1rem;">
    <div>Root</div>
    <img style="margin: auto;" src="public/img/backend-services.png" width="810" height="407" alt="backend-services">
    <div style="margin: 0.3rem;">Admin</div>
    <img style="margin: auto;" src="public/img/filament.png" width="810" height="407" alt="filament">
</div>

### Setup
1. run `sh fix-permissions.sh`
2. copy .env.example to .env and apply required changes
3. run `composer run dev` to an init project and start servers (`OCTANE`, `HORIZON`, `VITE`, `QUEUE`, `SCHEDULE`, `REVERB`, `PULSE`)
4. for use `OCTANE` with nginx you need to configure it from [doc](https://laravel.com/docs/12.x/octane#serving-your-application-via-nginx)
5. if you use `herd` goto http://bazaar-laravel.test
6. `admin` user credentials: admin@admin.com, password
7. activate your idea's `laravel pint inspection`
8. fill pusher credentials for use `chatify`
9. you are up, `explore` and have `fun`

### Docker
1. run `make` to see available commands
2. run `make build` to build docker images
3. run `make composer run dev` to init project
4. run `make composer testpf` to create test databases and run tests parallel
5. run `make horizon` to start horizon

### Testing
1. copy .env.testing.example to .env.testing and apply required changes
2. run `composer testpf` for create test databases and run tests parallel
3. if you set up `coverage` engine like Xdebug, you can get coverage report

### Commands
1. `search` commands with `php artisan find:art` and use --exact argument for exact search
2. `search` laravel document with `php artisan docs`
3. `composer ide-helper` - generate IDE helper files
4. `composer reload` - `git pull`, install all dependencies, clear all cache, filament asset updates, migrate and npm install and build
5. `composer cache` - cache system views, events, routes, modules and filament assets
6. `composer clean` - clear all cache
7. `composer deep-clean` - clear cache and data from database and storage
8. `composer testp` - run tests parallel
9. `composer testpf` - recreate test databases and run tests parallel
10. `composer dev` - run `composer reload` and `composer ide-helper` and queue:work
11. `composer prod` - run `git pull`, install no dev dependencies, clear all cache, run migrations, `composer cache`, queue:work
12. `composer start` - fire octane server
13. `composer pint` - run PHP code style fixer
14. `composer stop` - stop all servers
15. `composer reverb` - fire reverb server with output debug information
16. `composer deply` - run octane, horizon, reverb, vite and pulse, queue, schedule concurrently

## Tasks
1. refactor image upload operations in controllers
2. define Repositories for important actions
3. complete end-to-end tests for api routes
4. complete enums for status, types and more
5. cron jobs for scheduled tasks
6. fix gates for tools (horizon panel and more)
7. fix global latest scope for models
