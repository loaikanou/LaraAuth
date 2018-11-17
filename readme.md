<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Laravel 5.7 and Passport Authentication with API.

Please follow the guide.

1. `git clone`
2. `update the .env file along with database connection`
3. `composer install && composer update`
4. `php artisan key:generate`
5. `php artisan migrate`
6. `php artisan db:seed`

## Install Passport
Open a terminal window and install the passport using following command

 ```
 php artisan passport:install
 php artisan passport:keys
 ```

## Set the App URL
Set the APP_URL in `.env` file (e.g)

```
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

## Set the APP Title
```
APP_TITLE='Your App Name'
```

## Run PHP Dev Server

```
php artisan serve
```

#### Features:
- [x] Laravel 5.7
- [x] Add Passport for authentication
- [x] User Login
- [x] User Register
- [x] Users Crud
- [x] Form validation Server
- [x] Reset Password
- [x] Tests

#### API: [get postman](https://documenter.getpostman.com/view/2408327/RzZ7kygd).

#### By : Loai N Kanou