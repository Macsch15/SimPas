<?php

namespace SimPas\Providers;

use Illuminate\Support\ServiceProvider;
use App;

class BreadcrumbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('breadcrumb', function() {
            return new \SimPas\Breadcrumb\Breadcrumb();
        });
    }
}
