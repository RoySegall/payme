<?php

namespace App\Services;

class LogsService implements LogsServiceInterface
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
    public function setClient(\GuzzleHttp\Client $client): LogsService
    {
        $this->client = $client;

        return $this;
    }

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
    public function logError($type, $error) {
        $this->client->request(
            'POST',
            env('LOGZ_IO_URI') .
                '/?token=' .
                env('LOGZ_IO_TOKEN') .
                '&type=' . $type, ['json' => $error]);
    }

}
