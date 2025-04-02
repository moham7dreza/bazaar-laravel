# Bazaar App Made With Laravel
<div style="display:flex;">
    <img style="margin: auto;" src="public/img/backend-services.png" width="1260" height="963" alt="backend-services">
</div>

### setup
1. run `sh fix-permissions.sh`
2. copy .env.example to .env and apply required changes
3. run `composer run dev`
4. if you use herd goto http://bazaar-laravel.test
5. admin user credentials: admin@admin.com, password

### testing
1. copy .env.testing.example to .env.testing and apply required changes
2. run `composer testpf` for create test databases and run tests parallel

### Commands
1. `composer ide-helper` - generate IDE helper files
2. `composer reload` - `git pull`, install all dependencies, clear all cache, filament asset updates, migrate and npm install and build
3. `composer cache` - cache system views, events, routes, modules and filament assets
4. `composer testp` - run tests parallel
5. `composer testpf` - recreate test databases and run tests parallel
6. `composer dev` - run `composer reload` and `composer ide-helper` and queue:work
7. `composer prod` - run `git pull`, install no dev dependencies, clear all cache, run migrations, `composer cache`, queue:work

## Tasks
1. refactor image upload operations in controllers
2. define Repositories for important actions
3. create factories for models
4. write end-to-end tests for api routes
5. define enums for status, types and more
