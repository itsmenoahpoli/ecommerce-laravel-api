<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /** Relationships */
    public function product_categories()
    {
        return $this->belongsTo('App\Models\Products\ProductCategory');
    }

    public function product_images()
    {
        return $this->hasMany('App\Models\Products\ProductImage');
    }
}
