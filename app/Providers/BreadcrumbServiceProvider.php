<?php

namespace SimPas\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use SimPas\Breadcrumb\Breadcrumb;

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
        App::bind('breadcrumb', function () {
            return new Breadcrumb();
        });
    }
}
