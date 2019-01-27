<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PayMeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('\App\Services\ClearingService', function ($app) {
            return new \App\Services\ClearingService($app->get('\App\Services\LogsService'));
        });

        $this->app->bind('\App\Services\LogsService', function() {
            return new \App\Services\LogsService();
        });
    }
}
