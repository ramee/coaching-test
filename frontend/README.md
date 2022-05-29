# start

## build production
```shell
$ docker build -t ramee/coaching-test .
$ docker run -it -p 3000:80 --rm --name coaching-test ramee/coaching-test
```

## develop with watch
```shell
$ docker-compose run --rm app npm run install
$ docker-compose up
```
