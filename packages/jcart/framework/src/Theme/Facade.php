<?php

namespace Jcart\Framework\Theme;

use Illuminate\Support\Facades\Facade as LaraveFacade;

class Facade extends LaraveFacade
{
    protected static function getFacadeAccessor()
    {
        return 'theme';
    }
}
