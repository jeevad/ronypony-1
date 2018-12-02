<?php

namespace App\Contracts\Repository;

interface ProductAttributeIntegerValueInterface
{
    /**
     * Create an Attribute
     *
     * @param array $data
     * @return \App\Database\ProductAttributeIntegerValue
     */
    public function create($data);
}
