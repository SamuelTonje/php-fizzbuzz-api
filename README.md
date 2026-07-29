# FizzBuzz API

A REST API developed with Symfony to expose an implementation of the well-known FizzBuzz exercise.

## Stack

* PHP 8.4
* Symfony 8.1
* Docker
* Nginx

## Clone the project

```bash
git clone https://github.com/SamuelTonje/php-fizzbuzz-api.git

cd php-fizzbuzz-api
```

## Installation

Clone the project and install dependencies:

```bash
make install
```

## Running the application

Start the Docker environment:

```bash
make up
```

The application is available at:

```text
http://localhost:8080
```

## Available commands

Display available commands:

```bash
make help
```

Main commands:

```bash
make up        # Start containers
make down      # Stop containers
make install   # Install dependencies
make test      # Run tests
make bash      # Enter the PHP container
make logs      # Display logs
```

## Tests

Run tests:

```bash
make test
```

## Evolution

This README will be updated as the project evolves.
