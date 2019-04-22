<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class OrderItem extends Model
{
    use CrudTrait;

    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'price',
        'sku' .
        'attributes',
        'name',
        'name_sr'
    ];

    protected $casts = [
        'attributes' => 'array',
        'meta' => 'array'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product');
    }

    public function getNameTranslatedAttribute() {
        return Lang::locale() == 'en' ? $this->name : $this->name_sr;
    }
}
