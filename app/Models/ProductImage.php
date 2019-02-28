<?php

namespace App\Models;

use Storage;

class ProductImage extends BaseModel
{
    protected $fillable = ['product_id', 'path', 'is_main_image'];
    protected $hidden = ['created_at', 'updated_at'];
    protected static $path = 'uploads/catalog/images/';
    protected static $sizes = [
        'small' => ['150', '150'],
        'medium' => ['350', '350'],
        'large' => ['750', '750'],
    ];
    protected $casts = [
        'is_main_image' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPathAttribute($path)
    {
        if ($path) {
            $urls = [
                'original_url' => $this->imageURL($path),
            ];
            $sizes = static::$sizes;
            foreach ($sizes as $name => $size) {
                $urls[$name . '_url'] = $this->imageURL($path);
            }

            return $urls;
        }
    }

    public function imageURL($path)
    {
        if (is_url($path)) {
            return $path;
        }
        return Storage::disk('public')->url(static::$path . $path);
    }
}
