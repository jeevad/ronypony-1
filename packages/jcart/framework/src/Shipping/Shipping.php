<?php

namespace Jcart\Framework\Shipping;

abstract class Shipping
{
    abstract public function process($cartProducts);
}
