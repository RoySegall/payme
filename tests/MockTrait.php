<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

trait MockTrait
{

    /**
     * Mocking a http requests.
     *
     * @param \App\Services\ClearingService $clearing_service
     *  The clearing service object.
     */
    protected function mockHttpService(\App\Services\ClearingService $clearing_service)
    {
        $mock = new MockHandler();

        $mock->append(new Response(500, [], json_encode([
            'status_code' => 1,
            'status_error_details' => 'Invalid price',
            'status_additional_info' => 123,
            'status_error_code' => 352,
        ])));

        $mock->append(new Response(200, [], json_encode([
            'status_code' => 0,
            'sale_url' => 'http://google.com',
            'payme_sale_id' => 123,
            'payme_sale_code' => 352,
            'price' => 352,
            'transaction_id' => 352,
            'currency_id' => 352,
        ])));

        $handler = HandlerStack::create($mock);

        $clearing_service->setClient(new Client(['handler' => $handler]));
    }

    /**
     * Mocking HTTP request for the log service.
     *
     * @param \App\Services\LogsService $log_service
     *  The log service object.
     */
    protected function mockLogsService(\App\Services\LogsService $log_service)
    {
        $mock = new MockHandler();

        $mock->append(new Response(500, []));
        $mock->append(new Response(200));

        $handler = HandlerStack::create($mock);

        $log_service->setClient(new Client(['handler' => $handler]));
    }
}
