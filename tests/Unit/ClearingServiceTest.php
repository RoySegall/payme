<?php

namespace Tests\Unit;

use App\SalesInformation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\MockTrait;
use Tests\TestCase;

class ClearingServiceTest extends TestCase
{

    use MockTrait, RefreshDatabase;

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
        $this->assertEquals($this->clearingService->getLog(), (object) [
            'status_code' => 1,
            'status_error_details' => 'Invalid price',
            'status_additional_info' => 123,
            'status_error_code' => 352,
        ]);

        $results = $this->clearingService->paymentRequest(200, 200, 200);

        $log = $this->clearingService->getLog();

        $this->assertEquals($log, (object) [
            'status_code' => 0,
            'sale_url' => 'http://google.com',
            'payme_sale_id' => 123,
            'payme_sale_code' => 352,
            'price' => 352,
            'transaction_id' => 352,
            'currency_id' => 352,
        ]);
        $this->assertTrue($results);

        // Checking the sale information logged to the DB.
        $query_results = SalesInformation::where('payme_sale_code', $log->payme_sale_code)->first();
        $this->assertNotEmpty($query_results);
    }
}
