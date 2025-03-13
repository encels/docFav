.PHONY: up down build test install update schema-create schema-update

# Docker commands
up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

# Composer commands
install:
	docker-compose exec php composer install

update:
	docker-compose exec php composer update

# Database commands
schema-create:
	docker-compose exec php vendor/bin/doctrine orm:schema-tool:create

schema-update:
	docker-compose exec php vendor/bin/doctrine orm:schema-tool:update --force

# Testing
test:
	docker-compose exec php vendor/bin/phpunit
