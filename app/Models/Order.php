<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = 
    [
        'customer_id',
        'order_store_id',
        'employee_id',
        'ordered_at',
        'status',
        'total_amount',
        'delivery_type',
        'pickup_store_id',
        'delivery_address',
        'delivery_from',
        'delivery_to',
        'has_benefit',
        'note',
    ];
}