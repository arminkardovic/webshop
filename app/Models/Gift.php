<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use CrudTrait;

    public $timestamps = false;

    protected $fillable = [
        'from',
        'message',
        'value',
        'remaining',
        'code',
        'recipient_id'
    ];
}
