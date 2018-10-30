<?php

namespace App\Providers;

use App\Services\Sms\Nexmo;
use App\Services\Sms\SmsSender;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Laravel\Passport\Passport;
use App\Models\Pages\Page;
use App\Services\Banners\CostCalculator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.app', function($view){
            $view->with('menuPages', Page::whereIsRoot()->defaultOrder()->getModels());
        });

        $this->app->singleton(CostCalculator::class, function ($app) {
            $config = $app->make('config')->get('banner');
            return new CostCalculator($config['price']);
        });

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
