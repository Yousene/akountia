<?php
namespace EasyCollab\Quicky;

use Illuminate\Support\ServiceProvider;

class QuickyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('EasyCollab\Quicky\QuickyController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/Views', 'easycollab');
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/easycollab/quicky'),
        ]);
    }
}