<?php

namespace Jcart\Framework\Payment;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade
{
    protected static function getFacadeAccessor()
    {
        return 'Jcart\Framework\Payment\Manager';
    }
}
