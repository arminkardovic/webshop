<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use CrudTrait;

    protected $fillable = [
        'product_id',
        'stock',
        'price',
        'attributes',
        'sku'
    ];

    protected $casts = [
        'attributes' => 'array'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }
}
