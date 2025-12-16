<?php

namespace AnkitFromIndia\MX18;

use Illuminate\Support\ServiceProvider;
use AnkitFromIndia\MX18\Http\MX18Client;

class MX18ServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mx18.php', 'mx18');
        
        $this->app->singleton(MX18Client::class, function ($app) {
            return new MX18Client(config('mx18.api_token'));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/mx18.php' => config_path('mx18.php'),
        ], 'mx18-config');

        if ($this->app->runningInConsole()) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }
    }
}
