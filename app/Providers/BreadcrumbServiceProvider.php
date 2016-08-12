<?php

namespace SimPas\Providers;

use App;
use SimPas\Breadcrumb\Breadcrumb;
use Illuminate\Support\ServiceProvider;

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
            return new Breadcrumb();
        });
    }
}
