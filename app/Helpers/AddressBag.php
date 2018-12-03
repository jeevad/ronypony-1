<?php

namespace App\Helpers;

class AddressBag
{
    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function attributes(): array
    {
        return $this->attributes;
    }
}