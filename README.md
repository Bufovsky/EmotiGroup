## Installation
```
git clone Bufovsky/EmotiGroup
```
From terminal in cloned folder src 

```
cd .docker
docker compose up -d
```
In docker terminal PHP container

```
composer install 
# php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## Usage

Postman collection you can import by file "reservations.postman_collection".

At first run "user.register" at next "user.login" and copy token to authorization queries

All API routes:
- create: /v1/api/reservations
- get: /v1/api/reservations/1
- getList: /v1/api/reservations
- delete: /v1/api/reservations/1

If you want to create reservation by web browser you can use http://localhost:port url

## Summary

- Add more code coverage unit tests

## License

[MIT](https://choosealicense.com/licenses/mit/)