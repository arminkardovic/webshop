<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = [
        'stock', 'price', 'attributes'
    ];

//    protected $casts = [
//        'attributes' => 'array'
//    ];
}
