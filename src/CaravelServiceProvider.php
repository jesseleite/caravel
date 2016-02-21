<?php

namespace ThisVessel\Caravel;

use Blade;
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
        $this->publishes([
            __DIR__.'/Config/caravel.php' => config_path('caravel.php'),
        ], 'caravel-config');

        $this->loadViewsFrom(__DIR__.'/Views', 'caravel');

        $this->publishes([
            __DIR__.'/Views' => base_path('resources/views/vendor/caravel'),
        ], 'caravel-views');

        $this->publishes([
            __DIR__.'/Views/auth' => base_path('resources/views/auth'),
        ], 'caravel-auth');

        $this->publishes([
            __DIR__.'/Views/fields' => base_path('resources/views/vendor/caravel/fields'),
        ], 'caravel-fields');

        Blade::directive('field', function($expression) {
            return "<?php echo \$__env->make('caravel::components.field', ['field' => \$fields[$expression]], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        });
    }

    /**
     * Register things.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/caravel.php', 'caravel'
        );

        $this->app->register(BootFormsServiceProvider::class);
    }
}
