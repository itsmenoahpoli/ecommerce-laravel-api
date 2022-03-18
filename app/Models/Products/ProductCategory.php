<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    /** Relationships */
    public function products()
    {
        return $this->belongsTo('App\Models\Products\Product');
    }
}
