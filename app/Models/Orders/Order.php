<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    /** Relationships */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function order_shipping_address()
    {
        return $this->hasOne('App\Models\Orders\OrderShippingAddress');
    }
}
