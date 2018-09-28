<?php

namespace App\Providers;

use App\Services\Sms\Nexmo;
use App\Services\Sms\SmsSender;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(SmsSender::class, function ($app){
            $config = $app->make('config')->get('sms');
            return new Nexmo($config);
        });
    }
}
