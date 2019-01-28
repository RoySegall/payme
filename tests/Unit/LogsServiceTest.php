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

    public function testLog()
    {
        $this->assertTrue(true);
    }
}
