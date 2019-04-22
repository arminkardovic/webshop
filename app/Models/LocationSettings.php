<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class LocationSettings extends Model
{
    use CrudTrait;

    protected $table = 'location_settings';


    public $timestamps = false;

    protected $fillable = [
        'country',
        'locale',
        'currency',
        'exchange_rate'
    ];


}
