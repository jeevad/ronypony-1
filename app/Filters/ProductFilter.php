<?php

namespace App\Filters;

class ProductFilter extends Filters
{
    protected $filters = ['keyword'];

    protected function keyword($keyword)
    {
        return $this->builder->where('name', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%");
    }
}
