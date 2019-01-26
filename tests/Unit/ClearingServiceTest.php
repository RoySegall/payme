<?php

namespace Tests\Unit;

use Tests\MockTrait;
use Tests\TestCase;

class ClearingServiceTest extends TestCase
{

    use MockTrait;

    /**
     * @var \App\Services\ClearingService
     */
    protected $clearingService;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->clearingService = $this->app->get('\App\Services\ClearingService');
        $this->mockHttpService($this->clearingService);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPaymentRequest()
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
