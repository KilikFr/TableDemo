Kilik TableDemo for KilikTableBundle
====================================

This project is a simple way to present KilikTableBundle working features.

- [Live demo](http://tabledemo.kilik.fr/)
- [KilikTableBundle](https://github.com/KilikFr/TableBundle)

# installation

- check your requirements (mysql, php, composer, ...)
- checkout this project on github:
```
git clone https://github.com/KilikFr/TableDemo.git
cd TableDemo
```
- install dependencies:
```
composer install --ignore-platform-reqs
```
- install assets:
```
./bin/console assets:install --symlink
```
- and create schema database and load fixtures (from your project root):
```
./bin/dev-tools/full_reload.sh
```

# features demo

- simple list: [demo](http://tabledemo.kilik.fr/organisation/list) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/OrganisationController.php#L84)
- left join + concat: [demo](http://tabledemo.kilik.fr/contact/list) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/ContactController.php#L79)
- list with count (and group by): [demo](http://tabledemo.kilik.fr/organisation/list-groupby) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/OrganisationController.php#L148)
- additionnal filters (custom input): [demo](http://tabledemo.kilik.fr/organisation/list-custom) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/OrganisationController.php#L231)
- alternative pagination (+ setup on visible columns): [demo](http://tabledemo.kilik.fr/product/list) [src](https://github.com/KilikFr/TableDemo/blob/master/src/Kilik/TableDemoBundle/Controller/ProductController.php#L217)

