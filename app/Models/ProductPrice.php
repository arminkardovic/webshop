<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = [
        'product_id', 'stock', 'price', 'attributes'
    ];

    protected $casts = [
        'attributes' => 'array'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }
}
