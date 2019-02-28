<?php

namespace Jcart\Framework\Tabs;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{
    protected static function getFacadeAccessor()
    {
        return 'Jcart\Framework\Tabs\TabsMaker';
    }
}
