<?php
namespace App\Models;


class UserGroup extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'discount', 'discount_type'
    ];

    public $timestamps = false;

    /**
     * One User Group has Many User Attahced with it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMAny
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords($name);
    }
}
