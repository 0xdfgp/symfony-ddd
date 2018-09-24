# DDD with Symfony 4
This is a example of an implementation of DDD with Symfony 4.

## Requirements

- Docker
- Php 7.1
- composer

## Get started
You need to install all dependencies and start the local server (Pending to dockerize).

```bash
$ composer install
$ bin/console server:start
```

## Authentication
This app uses JWT. You can find the full api specification in the [openapi.yml](openapi.yml)

## Tests
 
### Unitary tests
Test coverage is important but if you a looking for a 100% you could finish with very fragile tests. That's the reason
because this unitary tests are based on behaviours instead of class by class.

```bash
bin/console/phpunit
```

### Functional tests
```bash
php vendor/bin/codecept run
```