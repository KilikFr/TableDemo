Kilik TableDemo for KilikTableBundle
====================================

This project is a simple way to present KilikTableBundle working features.

- [Live demo](http://tabledemo.kilik.fr/)
- [KilikTableBundle](https://github.com/KilikFr/TableBundle)

Installation
============

With docker
-----------
requirements:
- docker
- docker-compose
- a mysql database (you can use https://github.com/KilikFr/docker-mysql as a service)

```sh
git clone https://github.com/KilikFr/TableDemo.git
cd TableDemo
cp .env.dist .env
# edit the .env file to fix variables: nano .env
docker-compose build
docker-compose up -d
docker-compose exec --user www-data php composer install
docker-compose exec --user www-data php bin/console assets:install --symlink
docker-compose exec --user www-data php bin/console doctrine:database:create
docker-compose exec --user www-data php bin/console doctrine:schema:update --force
docker-compose exec --user www-data php bin/console faker:populate
docker-compose exec --user www-data php bin/console cache:clear --env=prod
```

and now, access the demo to the configured port.

Default is: http://localhost:8080

Without docker
--------------

- check your requirements (mysql, php, composer, ...)
- checkout this project on github:
```sh
git clone https://github.com/KilikFr/TableDemo.git
cd TableDemo
```
- install dependencies:
```sh
composer install --ignore-platform-reqs
```
- install assets:
```sh
./bin/console assets:install --symlink
```
- and create schema database and load fixtures (from your project root):
```sh
./bin/dev-tools/full_reload.sh
```

# features demo

- simple list: [demo](http://tabledemo.kilik.fr/organisation/list) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/OrganisationController.php#L84)
- left join + concat: [demo](http://tabledemo.kilik.fr/contact/list) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/ContactController.php#L79)
- list with count (and group by): [demo](http://tabledemo.kilik.fr/organisation/list-groupby) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/OrganisationController.php#L148)
- additionnal filters (custom input): [demo](http://tabledemo.kilik.fr/organisation/list-custom) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/OrganisationController.php#L231)
- alternative pagination (+ setup on visible columns): [demo](http://tabledemo.kilik.fr/product/list) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/ProductController.php#L217)
- force reset filter : [demo](http://tabledemo.kilik.fr/product/list?organisation=test)
- api webservice as data source: [demo](http://tabledemo.kilik.fr/api-demo/list)
