<?php

namespace App\Models;

use App\Facades\LocalFile;

class ProductImage extends BaseModel
{
    protected $fillable = ['product_id', 'path', 'is_main_image'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPathAttribute()
    {
        if (null === $this->attributes['path'] || empty($this->attributes['path'])) {
            return;
        }
        $symlink = config('site.symlink_storage_folder');
        $relativePath = $symlink . '/' .config('site.image.path').$this->attributes['product_id'].'/'. $this->attributes['path'];
        $localImage = new LocalFile($relativePath);

        return $localImage;
    }
}
