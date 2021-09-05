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
}
