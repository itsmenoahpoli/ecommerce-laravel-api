<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    /** Relationships */
    public function product()
    {
        return $this->belongsTo('App\Models\Products\Product');
    }
}
