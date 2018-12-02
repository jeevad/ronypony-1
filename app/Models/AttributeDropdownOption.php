<?php

namespace App\Models;

class AttributeDropdownOption extends BaseModel
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['attribute_id', 'display_text'];

    /**
     * Attribute Dropdown Options belongs to one Product Attribute.
     *
     * @return \App\Database\Attribute
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
