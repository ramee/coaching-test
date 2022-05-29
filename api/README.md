# coaching test

## install
```shell
$ cp .env.example .env
$ docker run --rm -it --volume $PWD:/app --user $(id -u):$(id -g) composer install
$ docker-compose run --no-deps --rm laravel.test php artisan key:generate
$ docker-compose run --rm laravel.test php artisan migrate
$ docker-compose run --rm laravel.test php artisan db:seed
```

## start containers
```shell
$ docker-compose up
```
