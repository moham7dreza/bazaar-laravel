# Bazaar App Made With Laravel
<div style="display:flex;">
    <img style="margin: auto;" src="public/img/backend-services.png" width="300" height="500" alt="backend-services">
</div>

### setup
1. copy .env.example to .env
2. apply required changes in .env
3. run `composer run dev`
4. if you use herd goto http://bazaar-laravel.test

### testing
1. copy .env.testing.example to .env.testing 
2. apply required changes in .evn.testing
3. run `composer testpf` for create test databases and run tests parallel

### Commands
1. `composer ide-helper` - generate IDE helper files
2. `composer reload` - clear all cache and reinstall all dependencies
3. `composer cache` - cache system views, events, routes, modules
4. `composer testp` - run tests parallel
5. `composer testpf` - recreate test databases and run tests parallel
6. `composer dev` - run `composer reload` and `composer ide-helper`, `git pull` and queue:work
7. `composer prod` - run `git pull`, clear all cache, install no dev dependencies, run migrations, `composer cache`, queue:work

## Tasks
1. refactor image upload operations in controllers
2. define Repositories for important actions
3. create factories for models
4. write end-to-end tests for api routes
5. define enums for status, types and more
