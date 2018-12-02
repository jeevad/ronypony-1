<?php

namespace App\Models;

class Attribute extends BaseModel
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'identifier']; //, 'data_type','field_type' ,'sort_order'];

    /**
     * The attributes has Many Dropdown Options.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeDropdownOptions()
    {
        return $this->hasMany(AttributeDropdownOption::class);
    }
    
    /**
     * The attributes has Many Products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
