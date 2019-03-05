<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Cart extends LaravelFacade
{
    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}
