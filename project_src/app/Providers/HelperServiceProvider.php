<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(base_path('app').'/Helpers/*.php') as $filename){
            require_once($filename);
        }

        foreach (glob(base_path('app').'/Helpers/V2/*.php') as $filename){
            require_once($filename);
        }
    }
}
