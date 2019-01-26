<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

trait MockTrait
{
    protected function mockService(\App\Services\ClearingService $clearing_service) {
        $mock = new MockHandler();

        $mock->append(new Response(500, [], json_encode([
            'status_code' => 1,
            'status_error_details' => 'Invalid price',
            'status_additional_info' => 123,
            'status_error_code' => 352,
        ])));

        $mock->append(new Response(200, [], json_encode([
            'status_code' => 0,
            'sal_url' => 'http://google.com',
            'payme_sale_id' => 123,
            'status_error_code' => 352,
        ])));

        $handler = HandlerStack::create($mock);

        $clearing_service->setClient(new Client(['handler' => $handler]));
    }
}
