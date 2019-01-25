<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ClearingServiceTest extends TestCase
{

    /**
     * @var \App\Services\ClearingService
     */
    protected $clearingService;

    /**
     * {@inheritdoc}
     */
    public function setUp() {
        parent::setUp();

        $this->clearingService = app(\App\Services\ClearingService::class);

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

        $this->clearingService->setClient(new Client(['handler' => $handler]));
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testExample()
    {
        $results = $this->clearingService->paymentRequest(200, 200, 200);

        $this->assertFalse($results);
        $this->assertEquals($this->clearingService->getLog(), (object)[
            'status_code' => 1,
            'status_error_details' => 'Invalid price',
            'status_additional_info' => 123,
            'status_error_code' => 352,
        ]);

        $results = $this->clearingService->paymentRequest(200, 200, 200);

        $this->assertEquals($this->clearingService->getLog(), (object) [
            'status_code' => 0,
            'sal_url' => 'http://google.com',
            'payme_sale_id' => 123,
            'status_error_code' => 352,
        ]);
        $this->assertTrue($results);
    }
}
