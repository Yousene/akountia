<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use \App\Models\Apparence;
use \App\Models\Menu;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view)
        {
            /*if (\Auth::check()) {
                $view->with('layout', \Auth::user()->role != 3 ? "layouts/back" : "layouts/client");
            }else {
                $view->with('layout', null);
            }*/

            /*$view->with('layout', 'layouts/'.$apparence->layout)
                 ->with('menus', Menu::getMenus())
                 ->with('apparence', $apparence);*/

            $apparence = Apparence::where('statut', "1")->first();
            $view->with('layout', 'layouts/back')
                 ->with('menus', Menu::getMenus())
                 ->with('apparence', $apparence);
        });

        
    }
}
