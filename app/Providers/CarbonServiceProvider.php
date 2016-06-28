<?php

namespace SimPas\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class CarbonServiceProvider extends ServiceProvider
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
        Carbon::setLocale(config('app.locale'));
    }
}
