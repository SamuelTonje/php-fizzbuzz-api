# FizzBuzz API

REST API built with Symfony implementing the common FizzBuzz exercise for technical interview purpose.

## Stack

* PHP 8.4
* Symfony 8.1
* Docker
* Nginx
* PHPUnit
* PHPStan
* PHP CS Fixer
* Deptrac
* NelmioApiDocBundle (OpenAPI)

## Architecture

The project follows a pragmatic DDD / Hexagonal Architecture.

* **Domain**: business logic
* **Application**: use cases
* **Infrastructure**: Symfony controllers, HTTP layer, validation and framework integration

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
make test        # Run PHPUnit
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

The project contains both unit and functional tests.

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
* PHP CS Fixer
* PHPStan
* Deptrac
* PHPUnit
