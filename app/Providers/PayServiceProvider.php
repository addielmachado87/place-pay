<?php
/**
 * Created by PhpStorm.
 * User: addiel
 * Date: 29/03/19
 * Time: 15:04
 */

namespace App\Providers;


use App\Services\GuzzleService;
use App\Services\PayService;
use Carbon\Laravel\ServiceProvider;

class PayServiceProvider extends ServiceProvider
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
        $this->app->singleton(PayService::class, function ($app) {

            return new PayService( new GuzzleService(new \GuzzleHttp\Client()),$_ENV['END_POINT'],$_ENV['IDENTIFICADOR'],$_ENV['SECRET_KEY']);
        });
    }
}