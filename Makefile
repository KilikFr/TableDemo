default:
	@echo "make build|up|stop|restart|down|php"

build:
	docker-compose build

up:
	docker-compose up -d

stop:
	docker-compose stop

restart:
	docker-compose stop
	docker-compose up -d

down:
	docker-compose down

php:
	docker-compose exec --user www-data php bash
