<?php

namespace SimPas\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('customCheckbox', 'components.form.custom_checkbox', [
            'name', 'label', 'checked',
        ]);

        Form::component('customRadio', 'components.form.custom_radio', [
            'name', 'label', 'checked',
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
