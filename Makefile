.PHONY: help status tests update

# User Id
UNAME = $(shell uname)

ifeq ($(UNAME), Linux)
    UID = $(shell id -u)
else
    UID = 1000
endif

## Display this help text
help:
	@awk '/^[a-zA-Z\-\_0-9]+:/ {                                                \
	nb = sub( /^## /, "", helpMsg );                                            \
	if(nb == 0) {                                                               \
		helpMsg = $$0;                                                      \
		nb = sub( /^[^:]*:.* ## /, "", helpMsg );                           \
	}                                                                           \
	if (nb)                                                                     \
		printf "\033[1;31m%-" width "s\033[0m %s\n", $$1, helpMsg;          \
	}                                                                           \
	{ helpMsg = $$0 }'                                                          \
	$(MAKEFILE_LIST) | column -ts:

## start the stack
start:
	docker-compose up -d

## stop the stack
stop:
	docker-composer stop

## up --> start (alias)
up: start

## down stop and remove non persistent data
down:
	docker-compose down

## enter in a (default) shell
shell: php

## enter in a php shell
php:
	docker-compose exec --user www-data php bash

## enter in an nginx shell
nginx:
	docker-compose exec --user www-data nginx bash

## show logs (follow)
logsf:
	docker-compose logs -tf

## show logs
logs:
	docker-compose logs -t

## pull dependencies
pull:
	docker-compose pull

## launch internal update
update:
	docker-compose exec --user www-data php ./update

