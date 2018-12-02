<?php

namespace App\Models;

use App\Database\Configuration;

class SiteCurrency extends BaseModel
{
    protected $fillable = ['code', 'name', 'conversion_rate', 'status'];

}
