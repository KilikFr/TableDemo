Kilik TableDemo for KilikTableBundle
====================================

This project is a simple way to present KilikTableBundle working features.

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
./bin/dev-tools/full_reload.ss
```

