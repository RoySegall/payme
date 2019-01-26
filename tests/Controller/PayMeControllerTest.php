<?php

namespace Tests\Controller;

use App\Http\Controllers\PayMeController;
use Illuminate\Http\JsonResponse;

class PayMeControllerTest extends \Tests\TestCase
{

    use \Tests\MockTrait;

    /**
     * Testing the controller requests.
     *
     * We won't use the method for testing the request since we cannot mock
     * the guzzle object and that won't help us for testing.
     */
    public function testStore() {

        $controller = new PayMeController();

        /** @var \Illuminate\Http\Request $request */
        $request = $this->app->get('\Illuminate\Http\Request');

        /** @var \App\Services\ClearingService $clearing_service */
        $clearing_service = $this->app->get('\App\Services\ClearingService');

        /** @var JsonResponse $response */
        $response = $controller->store($request, $clearing_service);

        $this->assertEquals($response->getData()->error, 'One of the items is missing: sale_price, currency, product_name');
        $this->assertEquals($response->getStatusCode(), 400);

        $request->sale_price = 2500;
        $request->currency = 'ILS';
        $request->product_name = 'pizza';

        $this->mockHttpService($clearing_service);

        /** @var JsonResponse $response */
        $response = $controller->store($request, $clearing_service);

        $this->assertEquals($response->getData()->message, 'Something went wrong during the clearing. Please check logs');
        $this->assertEquals($response->getStatusCode(), 400);

        $response = $controller->store($request, $clearing_service);

        $this->assertEquals($response->getData()->message, 'The clearing process went OK');
        $this->assertEquals($response->getStatusCode(), 200);
    }

}
