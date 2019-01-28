<?php

namespace App\Console\Commands;

use App\Services\ClearingService;
use Illuminate\Console\Command;

class Sandbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payme:sandbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(ClearingService $clearingService)
    {
        $clearingService->trackClearance(125, '2566', 'ils', '');
    }
}
