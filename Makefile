
help: ## Show Help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: up down test bash install logs

up: ## Start the containers
	docker compose up -d

down: ## Stop the containers
	docker compose down

install: ## Install the API
	docker compose exec php composer install

test: ## Run test
	docker compose exec php php bin/phpunit

bash: ## Enter the php container
	docker compose exec php bash

logs: ## Show api logs
	docker compose logs -f

