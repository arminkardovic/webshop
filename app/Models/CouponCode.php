<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    use CrudTrait;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'discount'
    ];
}
