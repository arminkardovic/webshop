<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Category extends Model
{
    use CrudTrait;

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'categories';
    //protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'lft',
        'rgt',
        'depth',
        'attribute_set_id',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'category_id');
    }

    public function products2()
    {
        return $this->hasMany('App\Models\Product', 'subcategory_id');
    }

    public function allProducts()
    {
        return Product::where(function($q) {
            $q->where('category_id', '=', $this->id)->orWhere('subcategory_id', '=', $this->id);
        });
    }

    public function cartRules()
    {
        return $this->belongsToMany('App\Models\CartRule');
    }

    public function attributeSet()
    {
        return $this->hasOne('App\Models\AttributeSet', 'id', 'attribute_set_id');
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
