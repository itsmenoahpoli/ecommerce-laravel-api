<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShippingAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    /** Relationships */
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
