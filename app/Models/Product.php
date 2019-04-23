<?php

namespace App\Models;

use App\Utils\PriceUtils;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use CrudTrait;

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'products';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'group_id',
        'category_id',
        'subcategory_id',
        'attribute_set_id',
        'name',
        'name_sr',
        'description',
        'description_sr',
        'price',
        'weight',
        'tax_id',
        'stock',
        'active',
        'gift',
        'created_at',
        'updated_at'
    ];

    protected $with = ["images"];
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

        static::deleting(function ($model) {
            $model->attributes()->detach();

            // Delete product images
            $disk = 'products';

            foreach ($model->images as $image) {
                // Delete image from disk
                if (\Storage::disk($disk)->has($image->name)) {
                    \Storage::disk($disk)->delete($image->name);
                }

                // Delete image from db
                $image->delete();
            }
        });
    }

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

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'category_id');
    }

    public function subcategory()
    {
        return $this->hasOne('App\Models\Category', 'subcategory_id');
    }

    public function attributes()
    {
        return $this->belongsToMany('App\Models\Attribute', 'attribute_product_value', 'product_id', 'attribute_id')->withPivot('value');
    }

    public function tax()
    {
        return $this->hasOne('App\Models\Tax');
    }

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage')->orderBy('order', 'ASC');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\ProductGroup');
    }

    public function cartRules()
    {
        return $this->belongsToMany('App\Models\CartRule');
    }

    public function specificPrice()
    {
        return $this->belongsTo('App\Models\SpecificPrice');
    }

    public function prices()
    {
        return $this->hasMany('App\Models\ProductPrice', 'product_id', 'id');

    }

    public function getNameTranslatedAttribute()
    {
        return Lang::locale() == 'en' ? $this->name : $this->name_sr;
    }

    public function getDescriptionTranslatedAttribute()
    {
        return Lang::locale() == 'en' ? $this->description : $this->description_sr;
    }


    public function getFeatureImageAttribute()
    {
        $image = $this->images()->first();
        if ($image) {
            $disk = 'products';
            if (Storage::disk($disk)->has($image->name)) {
                return Storage::disk($disk)->url($image->name);
            }
        }
        return "";
    }


    public function getFormattedPriceAttribute()
    {
        if (\Auth::guest())
            $currency = 'EUR';
        else
            $currency = \Auth::user()->locationSettings->currency;

        switch ($currency) {
            case 'EUR':
                $currency = '€';
                break;
            case 'USD':
                $currency = '$';
                break;
            case 'RSD':
                $currency = 'din.';
                break;
            default;
                break;
        }

        return PriceUtils::formatPrice($this->price) . ' ' . $currency;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeLoadCloneRelations($query)
    {
        $query->with('category', 'subcategory', 'attributes', 'images');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


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
