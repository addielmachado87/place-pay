<?php

namespace App\Providers;

use App\Services\GuzzleService;
use Illuminate\Support\ServiceProvider;

class GuzzleServiceProvider extends ServiceProvider
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
        $this->app->singleton(GuzzleService::class, function ($app) {
            return new GuzzleService( new \GuzzleHttp\Client());
        });
    }
}
