<?php

namespace App\Services;

interface ClearingServiceInterface
{

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient(): \GuzzleHttp\Client;

    /**
     * Setter for the client object.
     *
     * @param \GuzzleHttp\Client $client
     *  A client object. Could be a mock as well(for testing).
     *
     * @return ClearingService
     *  The current object.
     */
    public function setClient(\GuzzleHttp\Client $client): ClearingService;

    /**
     * @return \stdClass
     */
    public function getLog(): \stdClass;

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
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function paymentRequest($sale_price, $currency, $product_name);

    /**
     * Tracking the sale in the DB.
     *
     * @param $sale_number
     *  The sale number we got from the API.
     * @param $sale_price
     *  The sale price in cents.
     * @param $currency
     *  The currency.
     * @param $product_name
     *  The product name.
     *
     * @return mixed
     */
    public function trackClearance($sale_number, $sale_price, $currency, $product_name);
}
