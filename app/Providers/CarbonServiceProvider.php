<?php

namespace SimPas\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

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
        $this->setLocaleForCarbon();
    }

    /**
     * Set locale for Carbon.
     *
     * @return void
     */
    public function setLocaleForCarbon()
    {
        Carbon::setLocale(config('app.locale'));
    }
}
