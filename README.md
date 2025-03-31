# Bazaar App Made With Laravel

### setup
1. copy .env.example to .env
2. run `composer install`
3. run `php artisan key:gen`
4. apply required changes in .evn
5. run `php artisan migrate --seed`
6. run `composer ide-helper`

### testing
1. copy .env.testing.example to .env.testing 
2. apply required changes in .evn.testing
3. run `php artisan migrate --env=testing`
4. run `composer testp`

## Tasks
1. refactor image upload operations in controllers
2. define Repositories for important actions
3. create factories for models
4. write end-to-end tests for api routes
5. define enums for status, types and more
