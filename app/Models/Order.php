<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Store;
use App\Models\OrderItem;

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
        'delivery_postal_code',
        'delivery_from',
        'delivery_to',
        'has_benefit',
        'note',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function pickupStore()
    {
        return $this->belongsTo(Store::class, 'pickup_store_id');
    }
}