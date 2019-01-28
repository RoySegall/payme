<?php

namespace Tests\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesInformationControllerTest extends \Tests\TestCase
{

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        /** @var \App\Services\ClearingService $clearing_service */
        $clearing_service = $this->app->get('\App\Services\ClearingService');

        $items = [
            [
                'payme_sale_number' => 125,
                'product' => 'Pizza with pineapple',
                'price' => '2500',
                'currency' => 'ILS',
            ],
            [
                'payme_sale_number' => 3000,
                'product' => 'Spongebob action figure',
                'price' => '2500',
                'currency' => 'ILS',
            ],
            [
                'payme_sale_number' => 1500,
                'product' => 'Patrick start action figure',
                'price' => '2500',
                'currency' => 'ILS',
            ],
            [
                'payme_sale_number' => 125,
                'product' => 'Water',
                'price' => '2500',
                'currency' => 'ILS',
            ],
        ];

        foreach ($items as $item) {
            $clearing_service->trackClearance(
                $item['payme_sale_number'],
                $item['price'],
                $item['currency'],
                $item['product']
            );
        }
    }

    /**
     * Testing the controller for getting all the sale information items.
     */
    public function testStore()
    {
        $response = $this->get('/api/sales');

        $response->assertStatus(200);
        $response->assertSeeText('Pizza with pineapple');
        $response->assertSeeText('Spongebob action figure');
        $response->assertSeeText('Patrick start action figure');
        $response->assertSeeText('Water');
    }
}
