<?php

namespace App\Models;

class ProductDownloadableUrl extends BaseModel
{
    protected $fillable = ['product_id', 'demo_path', 'main_path', 'token'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

}
