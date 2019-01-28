# Payme assignment

[![Build Status](https://travis-ci.org/RoySegall/payme.svg?branch=master)](https://travis-ci.org/RoySegall/payme)

## Setting up
First, let's copy the example `.env` file to our custom one:

```bash
cp .env.example .env
```

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

## Logging
When a clearance action will fail we will log it to a log service. The chosen
service is logz.io. In order to set it up edit in the `.env` file the logz.io 
keys:

```dotenv
LOGZ_IO_URI="LISTENER_URI"
LOGZ_IO_TOKEN="TOKEN"
```

The uri and the token are available in the logz.io dashboard under:
`Logz Shipping -> Libraries -> Bulk HTTP/S`

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

#### Logging
You log data using the service `\App\Services\LogsService`. Here is an example
on how to use it:
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Sandbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(\App\Services\LogsService $logs_service)
    {
        $logs_service->logError('foo', ['error' => 'content']);
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
