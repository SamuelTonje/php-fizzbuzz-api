# FizzBuzz API

REST API built with Symfony implementing the common FizzBuzz exercise for technical interview purpose.

## Stack

* PHP 8.4
* Symfony 8.1
* Docker
* Nginx
* MySQL 8.4
* Doctrine ORM
* Doctrine Migrations
* PHPUnit
* PHPStan
* PHP CS Fixer
* Deptrac
* NelmioApiDocBundle (OpenAPI)

## Architecture

The project follows a pragmatic DDD / Hexagonal Architecture.

* **Domain**: business logic
* **Application**: use cases, commands and domain events
* **Infrastructure**: Symfony controllers, HTTP layer, validation, Doctrine persistence and framework integration

## Installation

Clone the repository:

```bash
git clone https://github.com/SamuelTonje/php-fizzbuzz-api.git

cd php-fizzbuzz-api
```

Install dependencies:

```bash
make install
```

## Running the application

Start the application:

```bash
make up
```

The API is available at:

[http://localhost:8080](http://localhost:8080)

## API Documentation

Swagger UI is available at:

[http://localhost:8080/docs](http://localhost:8080/docs)

## Database

The application uses MySQL with Doctrine ORM.

Database migrations are managed with Doctrine Migrations.

Run migrations:

```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```

## Endpoints

### Health check

```http
GET /health
```

Response:

```json
{
    "status": "ok"
}
```

### Generate FizzBuzz

```http
POST /api/fizzbuzz
```

Request:

```json
{
    "int1": 3,
    "int2": 5,
    "limit": 15,
    "str1": "Fizz",
    "str2": "Buzz"
}
```

Response:

```json
[
    1,
    2,
    "Fizz",
    4,
    "Buzz",
    "Fizz",
    7,
    8,
    "Fizz",
    "Buzz",
    11,
    "Fizz",
    13,
    14,
    "FizzBuzz"
]
```

# Statistics

The API now tracks FizzBuzz executions.

Each request generates a `FizzBuzzGeneratedEvent` which is handled by a dedicated event listener.

The statistics table stores:

* first divisor
* second divisor
* upper limit
* first replacement
* second replacement
* number of executions (`hits`)
* creation date
* update date

If the same FizzBuzz configuration is requested multiple times, the existing record is updated and the `hits` counter is incremented.

### Get most used FizzBuzz parameters

```http
GET /api/fizzbuzz/statistics
```

Response:

```json
{
    "int1": 3,
    "int2": 5,
    "limit": 15,
    "str1": "Fizz",
    "str2": "Buzz",
    "hits": 42
}
```

Returns the most frequently used FizzBuzz configuration based on the execution counter.

## Database migrations

Create a migration:

```bash
php bin/console make:migration
```

Execute migrations:

Development:

```bash
php bin/console doctrine:migrations:migrate
```

Test environment:

```bash
php bin/console doctrine:migrations:migrate --env=test --no-interaction
```

## Available commands

Display all available commands:

```bash
make help
```

Main commands:

```bash
make up          # Start containers
make down        # Stop containers
make install     # Install dependencies
make test        # Prepare test database and run PHPUnit
make phpstan     # Run static analysis
make deptrac     # Check architecture rules
make lint        # Lint Symfony container and YAML
make cs-fixer    # Fix coding standards
make cs-check    # Check coding standards
make bash        # Open a shell in the PHP container
make logs        # Show application logs
make all         # Run all quality checks
```

## Tests

Run the test suite:

```bash
make test
```

The project contains:

* Unit tests
* End-to-end tests

The test workflow automatically:

1. Creates the test database if it does not exist
2. Runs Doctrine migrations
3. Executes PHPUnit

Database changes are isolated between tests using transactions.

## Code quality

Run all checks before pushing your changes:

```bash
make all
```

This command runs:

* Symfony lint
* PHP CS Fixer
* PHPStan
* Deptrac
* PHPUnit

## Continuous Integration

GitHub Actions runs the following checks on every push and pull request:

* Composer validation
* PHP dependency installation
* Test database preparation
* Doctrine migrations
* PHP CS Fixer
* PHPStan
* Deptrac
* PHPUnit

The CI pipeline runs using the Symfony test environment.
