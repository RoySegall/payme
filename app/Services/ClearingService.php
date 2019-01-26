<?php

namespace App\Services;

class ClearingService implements ClearingServiceInterface
{

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \stdClass
     */
    protected $log;

    /**
     * ClearingService constructor.
     */
    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }

    /**
     * {@inheritdoc}
     */
    public function getClient(): \GuzzleHttp\Client
    {
        return $this->client;
    }

    /**
     * {@inheritdoc}
     */
    public function setClient(\GuzzleHttp\Client $client): ClearingService
    {
        $this->client = $client;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLog(): \stdClass
    {
        return $this->log;
    }

    /**
     * {@inheritdoc}
     */
    public function paymentRequest($sale_price, $currency, $product_name)
    {
        $this->log = null;

        $payload = [
            'seller_payme_id' => env('PAYME_SELLER_ID'),
            'installment' => 1,
            'language' => 'en',
            'sale_price' => $sale_price,
            'currency' => $currency,
            'product_name' => $product_name,
        ];

        try {
            $results = $this->client->request(
                'POST',
                'https://preprod.paymeservice.com/api/generate-sale',
                ['json' => $payload]
            );

            $results = json_decode($results->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            $results = json_decode($e->getResponse()->getBody()->getContents());
        }

        // Expose it to outside the service.
        $this->log = $results;

        if ($results->status_code === 0) {
            // The process marked as a success.
            // todo: Create an entry in the table entity.
            return true;
        }

        // todo: log the error.
        return false;
    }
}
