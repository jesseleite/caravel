<?php

namespace ThisVessel\Caravel;

use Illuminate\Support\ServiceProvider;

class CaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap things.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'caravel');

        $this->publishes([
            __DIR__.'/Config/caravel.php' => config_path('caravel.php'),
        ], 'config');
    }

    /**
     * Register things.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
