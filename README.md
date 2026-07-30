# FizzBuzz API

REST API developed with Symfony to expose an implementation of the famous FizzBuzz exercise.

## Stack

* PHP 8.4
* Symfony 8.1
* Docker
* Nginx
* PHPUnit
* PHPStan
* PHP CS Fixer

## Architecture

The project follows a pragmatic **DDD and Hexagonal Architecture** approach.

* **Domain**: business rules and FizzBuzz logic
* **Application**: use cases and application workflows
* **Infrastructure/Symfony**: HTTP controllers, framework integration and technical concerns

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

Start the Docker environment:

```bash
make up
```

The API is available at:

```text
http://localhost:8080
```

## Health Check

The application exposes a health check endpoint:

```http
GET /health
```

Example response:

```json
{
    "status": "ok"
}
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
make test        # Run PHPUnit tests
make phpstan     # Run PHPStan analysis
make cs-fixer    # Fix code style
make cs-check    # Check code style
make bash        # Enter PHP container
make logs        # Display logs
```

## Tests

Run the test suite:

```bash
make test
```

## Code Quality

Static analysis:

```bash
make phpstan
```

Code style validation:

```bash
make cs-check
```

Apply code style fixes:

```bash
make cs-fixer
```

## Continuous Integration

GitHub Actions automatically runs:

* Composer validation
* Dependency installation
* PHPStan analysis
* PHP CS Fixer validation
* PHPUnit tests

on every push and pull request.

## Evolution

This README will be enriched as the project evolves.
