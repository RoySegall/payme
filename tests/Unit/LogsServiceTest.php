<?php

namespace Tests\Unit;

use Tests\MockTrait;
use Tests\TestCase;

class LogsServiceTest extends TestCase
{

    use MockTrait;

    /**
     * @var \App\Services\LogsService
     */
    protected $logsService;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->logsService = $this->app->get('\App\Services\LogsService');
        $this->mockLogsService($this->logsService);
    }

    /**
     * Making sure the requests will be sent to the server as we mock them.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testLog()
    {
        $this->assertFalse($this->logsService->logError('random-message', ['pizza']));
        $this->assertTrue($this->logsService->logError('random-message', ['pizza' => 'yummy!']));
    }
}
