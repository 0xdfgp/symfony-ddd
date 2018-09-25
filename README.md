# DDD with Symfony 4
This is a example of an implementation of DDD with Symfony 4.

## Requirements

- Docker

## Get started
You need to run the docker image and install all dependencies.

```bash
$ docker-compose up -d
$ docker exec -it app_php composer install
```

## Authentication
This app uses JWT. You can find the full api specification in the [openapi.yml](openapi.yml)

## Tests
 
### Unitary tests
Test coverage is important but if you are looking for a 100% you could finish with very fragile tests. That's the reason
because this unitary tests are based on behaviours instead of class by class.

```bash
docker exec -it app_php bin/phpunit
```

### Functional tests
```bash
docker exec -it app_php vendor/bin/codecept run
```