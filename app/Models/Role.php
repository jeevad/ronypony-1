<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords($name);
    }

    public function setSlugAttribute($slug)
    {
        $this->attributes['slug'] = str_slug($slug);
    }
}
