<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Lang;

class Attribute extends Model
{
    use CrudTrait;

 	/*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'attributes';
    //protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
    	'type',
	 	'name',
        'name_sr'
 	];
    // protected $hidden = [];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| EVENTS
	|--------------------------------------------------------------------------
	*/
	protected static function boot()
    {
        parent::boot();

    	static::deleting(function(Attribute $model) {
	            $model->sets()->sync([]);
    	        $model->values()->delete();
        });
    }

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    public function getNameTranslatedAttribute()
    {
        return Lang::locale() == 'en' ? $this->name : $this->name_sr;
    }

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	public function values()
    {
        return $this->hasMany('App\Models\AttributeValue', 'attribute_id');
    }

    public function sets()
    {
    	return $this->belongsToMany('App\Models\AttributeSet', 'attribute_attribute_set', 'attribute_id', 'attribute_set_id');
    }

    /*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| ACCESORS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/

}
