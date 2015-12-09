<?php

namespace ThisVessel\Caravel;

use Illuminate\Support\ServiceProvider;
use AdamWathan\BootForms\BootFormsServiceProvider;

class CaravelServiceProvider extends ServiceProvider
{
    /**
	 * Should I defer?
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Bootstrap things.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'caravel');

        $this->publishes([
            __DIR__.'/../config/caravel.php' => config_path('caravel.php'),
        ], 'config');
    }

    /**
     * Register things.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/caravel.php', 'caravel'
        );

        $this->app->register(BootFormsServiceProvider::class);
    }
}
