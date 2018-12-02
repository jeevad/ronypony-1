<?php

namespace App\Repositories;

use App\Models\Product;
use App\Contracts\Repository\ProductInterface;

class ProductRepository implements ProductInterface
{
    /**
     * Find a Product by a given id of a product
     *
     * @param integer $id
     * @return \App\Models\Product
     */
    public function find($id)
    {
        return Product::find($id);
    }

    /**
    * Find a Product by a given id of a product
    *
    * @param integer $id
    * @return \App\Models\Product
    */
    public function findBySlug($slug)
    {
        return Product::whereSlug($slug)->first();
    }

    /**
    * Find all product except the Variable Product to display
    *
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function query()
    {
        return Product::query();
    }
}
