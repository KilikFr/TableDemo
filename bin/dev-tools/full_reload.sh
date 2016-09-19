#!/bin/bash
./bin/console doctrine:schema:drop --force
./bin/console doctrine:schema:create
./bin/console faker:populate
./bin/console doctrine:query:sql "UPDATE product SET id_category=NULL WHERE RAND() <= 0.1"
