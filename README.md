# Payme assignment

[![Build Status](https://travis-ci.org/RoySegall/payme.svg?branch=master)](https://travis-ci.org/RoySegall/payme)

## Setting up
Once you got the a seller payme ID add it to the `.env` file. It suppose to look
like this:
```dotenv
PAYME_SELLER_ID="ID"
```

Then run in your terminal:
```bash
composer install
```

## REST api documentation

just go to https://roysegall.github.io/payme/

## Tests
We have two kind of tests: coding standards and unit test. In order to run it
just run in your CLI from the root folder:
```bash
./vendor/bin/phpunit tests
./vendor/bin/phpcs app --colors --standard=psr2
./vendor/bin/phpcs tests --colors --standard=psr2
```
