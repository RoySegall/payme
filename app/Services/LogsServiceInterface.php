<?php

namespace App\Services;

interface LogsServiceInterface
{
    /**
     * ClearingService constructor.
     */
    public function __construct();

    /**
     * {@inheritdoc}
     */
    public function getClient(): \GuzzleHttp\Client;

    /**
     * {@inheritdoc}
     */
    public function setClient(\GuzzleHttp\Client $client): LogsServiceInterface;

    /**
     * Logging error.
     *
     * @param $type
     *  The type of the error.
     * @param $error
     *  The error to log.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function logError($type, $error);
}
