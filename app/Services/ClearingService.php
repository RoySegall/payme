<?php

namespace App\Services;

class ClearingService implements ClearingServiceInterface
{

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * ClearingService constructor.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient(): \GuzzleHttp\Client
    {
        return $this->client;
    }

    /**
     * Setter for the client object.
     *
     * @param \GuzzleHttp\Client $client
     *  A client object. Could be a mock as well(for testing).
     *
     * @return ClearingService
     *  The current object.
     */
    public function setClient(\GuzzleHttp\Client $client): ClearingService
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Creating request for clearing.
     *
     * @param $sale_price
     *  The sale price in cents.
     * @param $currency
     *  The currency.
     * @param $product_name
     *  The product name.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function paymentRequest($sale_price, $currency, $product_name): void
    {
        $payload = [
            'seller_payment_id' => env('seller_payment_id'),
            'installment' => 1,
            'language' => 'en',
            'sale_price' => $sale_price,
            'currency' => $currency,
            'product_name' => $product_name,
        ];

        $results = $this->client->request(
            'POST',
            'https://preprod.paymeservice.com/api/generate-sale',
            ['body' => $payload]
        );

        return $results;
    }


}
