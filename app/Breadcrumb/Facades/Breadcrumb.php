<?php

namespace SimPas\Breadcrumb\Facades;

use Illuminate\Support\Facades\Facade;

class Breadcrumb extends Facade
{
    /**
     * {@inherindoc}.
     */
    protected static function getFacadeAccessor()
    {
        return 'breadcrumb';
    }
}
