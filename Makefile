
help: ## Show Help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: up down test bash install logs

up: ## Start the containers
	docker compose up -d

down: ## Stop the containers
	docker compose down

install: up ## Install the API
	docker compose exec php composer install

test: ## Run test
	docker compose exec php php bin/phpunit

phpstan: ## Run PHPStan analysis
	docker compose exec php vendor/bin/phpstan analyse

cs-fixer: ## Fix PHP code style
	docker compose exec php vendor/bin/php-cs-fixer fix

cs-check: ## Check PHP code style
	docker compose exec php vendor/bin/php-cs-fixer fix --dry-run --diff

deptrac: ## Architecture check
	docker compose exec php vendor/bin/deptrac analyse

bash: ## Enter the php container
	docker compose exec php bash

logs: ## Show api logs
	docker compose logs -f

clean: ## Destroy all Docker containers, images, volumes and networks
	@echo "Suppression complète de Docker (conteneurs, images, volumes, réseaux)..."
	@docker rm -f $$(docker ps -aq) 2>/dev/null || true
	@docker volume rm $$(docker volume ls -q) 2>/dev/null || true
	@docker system prune -a --volumes -f
	@docker network prune -f
	@echo "Docker complètement nettoyé !"
