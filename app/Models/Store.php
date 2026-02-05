<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name',
        'code',
        'postal_code',
        'prefecture',
        'city',
        'address_line', 
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

}
