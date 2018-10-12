<?php

namespace App\Providers;

use App\Services\Sms\Nexmo;
use App\Services\Sms\SmsSender;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Laravel\Passport\Passport;
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

        $this->app->singleton(Client::class, function ($app) {
            $config = $app->make('config')->get('elasticsearch');
            return ClientBuilder::create()
                ->setHosts($config['hosts'])
                ->setRetries($config['retries'])
                ->build();
        });

        Passport::ignoreMigrations();
    }
}
