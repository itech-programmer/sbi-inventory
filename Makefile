APP_CONTAINER := app
DB_CONTAINER := db
ENV_FILE := .env

.PHONY: start up down restart build composer-install migrate seed logs bash optimize cache-clear

start:
	@test -f $(ENV_FILE) || cp .env.example $(ENV_FILE)
	@docker-compose up -d --build
	@docker-compose exec $(APP_CONTAINER) composer install
	@docker-compose exec $(APP_CONTAINER) php artisan key:generate
	@docker-compose exec $(APP_CONTAINER) php artisan migrate:fresh --seed

up:
	docker-compose up -d

down:
	docker-compose down

restart:
	docker-compose down && docker-compose up -d

build:
	docker-compose build --no-cache

composer-install:
	docker-compose run --rm $(APP_CONTAINER) composer install --no-dev --optimize-autoloader

migrate:
	docker-compose run --rm $(APP_CONTAINER) php artisan migrate --force

seed:
	docker-compose run --rm $(APP_CONTAINER) php artisan db:seed --force

logs:
	docker-compose logs -f

fresh:
	docker-compose exec $(APP_CONTAINER) php artisan migrate:fresh --seed

test:
	docker compose exec $(APP_CONTAINER) php artisan test

queue:
	docker compose exec queue php artisan queue:work

bash:
	docker exec -it $(APP_CONTAINER) bash

optimize:
	docker-compose run --rm $(APP_CONTAINER) php artisan config:cache && \
	docker-compose run --rm $(APP_CONTAINER) php artisan route:cache && \
	docker-compose run --rm $(APP_CONTAINER) php artisan view:cache

cache-clear:
	docker-compose run --rm $(APP_CONTAINER) php artisan cache:clear && \
	docker-compose run --rm $(APP_CONTAINER) php artisan config:clear && \
	docker-compose run --rm $(APP_CONTAINER) php artisan route:clear && \
	docker-compose run --rm $(APP_CONTAINER) php artisan view:clear