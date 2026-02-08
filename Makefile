.PHONY: help up down restart build logs shell test migrate migrate-fresh migrate-refresh seed fresh model

.DEFAULT_GOAL := help

help: ## Show this help message
	@echo ""
	@echo "░▀▀█░▀▀█░█░█░░░█▄█░▀█▀░█▀▀░█▀▀░▀█▀░█▀█░█▀█░░░█▄█░█▀█░▀█▀░█░░░█▀▀░█▀▄"
	@echo "░░░█░░░█░█▀▄░░░█░█░░█░░▀▀█░▀▀█░░█░░█░█░█░█░░░█░█░█▀█░░█░░█░░░█▀▀░█▀▄"
	@echo "░▀▀░░▀▀░░▀░▀░░░▀░▀░▀▀▀░▀▀▀░▀▀▀░▀▀▀░▀▀▀░▀░▀░░░▀░▀░▀░▀░▀▀▀░▀▀▀░▀▀▀░▀░▀"
	@echo ""
	@echo ""
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
	@echo ""

up: ## Start Docker containers
	./vendor/bin/sail up -d

down: ## Stop Docker containers
	./vendor/bin/sail down

down-v: ## Stop containers and remove volumes
	./vendor/bin/sail down -v

restart: ## Restart containers
	./vendor/bin/sail restart

build: ## Rebuild images and start containers
	./vendor/bin/sail build --no-cache
	./vendor/bin/sail up -d

logs: ## Show container logs
	./vendor/bin/sail logs -f

bash: ## Access application container shell
	./vendor/bin/sail shell

test: ## Run tests
	./vendor/bin/sail test

migrate: ## Run migrations
	./vendor/bin/sail artisan migrate

migrate-fresh: ## Drop all tables and run migrations
	./vendor/bin/sail artisan migrate:fresh

migrate-refresh: ## Reset and run migrations again
	./vendor/bin/sail artisan migrate:refresh

seed: ## Run seeders
	./vendor/bin/sail artisan db:seed

model: ## Create a new model (use: make model NAME=ModelName)
	./vendor/bin/sail artisan make:model $(NAME) -mfs

migration: ## Create a new migration (use: make migration NAME=migration_name)
	./vendor/bin/sail artisan make:migration $(NAME)

controller: ## Create a new controller (use: make controller NAME=ControllerName)
	./vendor/bin/sail artisan make:controller $(NAME)

seeder: ## Create a new seeder (use: make seeder NAME=SeederName)
	./vendor/bin/sail artisan make:seeder $(NAME)

factory: ## Create a new factory (use: make factory NAME=FactoryName)
	./vendor/bin/sail artisan make:factory $(NAME)

install: ## Install project dependencies
	./vendor/bin/sail composer install

optimize: ## Optimize Laravel (cache config, routes, views)
	./vendor/bin/sail artisan optimize

clear: ## Clear all caches
	./vendor/bin/sail artisan optimize:clear
	./vendor/bin/sail artisan cache:clear
	./vendor/bin/sail artisan config:clear
	./vendor/bin/sail artisan route:clear
	./vendor/bin/sail artisan view:clear

queue: ## Start queue worker for processing jobs (emails)
	./vendor/bin/sail artisan queue:work

queue-listen: ## Start queue listener (restarts on code changes)
	./vendor/bin/sail artisan queue:listen

swagger: ## Generate Swagger/OpenAPI documentation
	./vendor/bin/sail artisan l5-swagger:generate
