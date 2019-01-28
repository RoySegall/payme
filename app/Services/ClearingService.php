<?php

namespace App\Services;

use App\SalesInformation;

class ClearingService implements ClearingServiceInterface
{

    /**
     * @var LogsService
     */
    protected $logService;

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
     *
     * @param LogsService $logs_service
     */
    public function __construct(LogsService $logs_service)
    {
        $this->client = new \GuzzleHttp\Client();
        $this->logService = $logs_service;
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
            $this->trackClearance(
                $results->payme_sale_code,
                $sale_price,
                $currency,
                $product_name,
                $results->sale_url
            );
            return true;
        }

        $this
            ->logService
            ->logError('clearing-issues', ['message' => 'Clearing issues', 'clearing_info' => $this->log]);

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function trackClearance($sale_number, $sale_price, $currency, $product_name, $payment_link)
    {
        $sale_information = new SalesInformation();
        $sale_information->payme_sale_code = $sale_number;
        $sale_information->price = $sale_price;
        $sale_information->currency = $currency;
        $sale_information->product = $product_name;
        $sale_information->payment_link = $payment_link;
        $sale_information->save();
    }
}
