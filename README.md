# Kilik TableDemo for KilikTableBundle

This project is a simple way to present KilikTableBundle working features.

- [Live demo](http://tabledemo.kilik.fr/)
- [KilikTableBundle](https://github.com/KilikFr/TableBundle)
- [KilikTableDemo](https://github.com/KilikFr/TableDemo)

## Installation

requirements:
- docker
- docker-compose
- make

```sh
git clone https://github.com/KilikFr/TableDemo.git kilik-table-demo
cd kilik-table-demo
make upgrade
```

## load fixtures

```shell
touch .fixtures
make fixtures
```

## work with php / symfony

```shell
make php
./bin/console
```

## common access

* application: http://tabledemo.localhost/
* phpmyadmin: http://pma.tabledemo.localhost/


# features demo

- simple list: [demo](http://tabledemo.kilik.fr/organisation/list) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/OrganisationController.php#L84)
- left join + concat: [demo](http://tabledemo.kilik.fr/contact/list) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/ContactController.php#L79)
- list with count (and group by): [demo](http://tabledemo.kilik.fr/organisation/list-groupby) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/OrganisationController.php#L148)
- additionnal filters (custom input): [demo](http://tabledemo.kilik.fr/organisation/list-custom) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/OrganisationController.php#L231)
- alternative pagination (+ setup on visible columns): [demo](http://tabledemo.kilik.fr/product/list) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/ProductController.php#L217)
- force reset filter : [demo](http://tabledemo.kilik.fr/product/list?organisation=test)
- ~~api webservice as data source: unmaintained~~
