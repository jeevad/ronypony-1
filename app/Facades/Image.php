<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Image extends LaravelFacade
{
    protected static function getFacadeAccessor()
    {
        return 'image';
    }
}
