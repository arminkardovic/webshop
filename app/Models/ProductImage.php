<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use CrudTrait;

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'product_images';
    //protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'product_id',
        'name',
        'order'
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

    /**
     * Get the image path on disk.
     *
     * @return string
     */
    public function getNameAttribute($name)
    {
        return substr($this->product_id, 0, 1) . DIRECTORY_SEPARATOR . $this->product_id . DIRECTORY_SEPARATOR . $name;
    }

    public function getUrlAttribute($name)
    {
        $disk = 'products';
        if (Storage::disk($disk)->has($this->name)) return Storage::disk($disk)->url($this->name);
        return "#";
    }

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}
