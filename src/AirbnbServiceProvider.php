<?php

namespace Amarkhai\AirbnbSdk;

use Illuminate\Support\ServiceProvider;

class AirbnbServiceProvider extends ServiceProvider
{
    /**
     * Publish the configuration file
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/airbnb.php' => config_path('airbnb.php'),
        ]);
    }

    /**
     * Merge config file if it already exists
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/airbnb.php', 'airbnb');
    }
}
