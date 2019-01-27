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

## Serving
In the root folder run:
```bash
php artisan serve
```

This will fire up the dev server. For more info just go to 
https://roysegall.github.io/payme

## Code

### Using built in services

#### Clearing
In order to use the clearing you can inject the class 
`\App\Services\ClearingService` to a router callback or a command. It suppose to
look like this:
```php
<?php

namespace App\Http\Controllers;

use App\Services\ClearingService;
use Illuminate\Http\Request;

class PayMeController extends Controller
{

    /**
     * create a payment request.
     *
     * @param Request $request
     *  The request service.
     * @param ClearingService $clearing_service
     *  The clearing service.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(Request $request, ClearingService $clearing_service)
    {
        return $clearing_service->paymentRequest(2500, 'ILS', 'Pizza');
    }
}
```

### Tests
We have two kind of tests: coding standards and unit test. In order to run it
just run in your CLI from the root folder:
```bash
./vendor/bin/phpunit tests
./vendor/bin/phpcs app --colors --standard=psr2
./vendor/bin/phpcs tests --colors --standard=psr2
```
