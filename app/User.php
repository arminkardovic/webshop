<?php

namespace App;

use App\Models\Product;
use Backpack\CRUD\CrudTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Backpack\Base\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable, HasRoles, CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'users';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'address',
        'description',
        'activation_code',
        'salutation',
        'birthday',
        'gender',
        'active',
        'location_settings_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $notificationVars = [
        'userSalutation',
        'userName',
        'userEmail',
        'age',
    ];

    /*
    |--------------------------------------------------------------------------
    | NOTIFICATIONS VARIABLES
    |--------------------------------------------------------------------------
    */
    public function notificationVariables()
    {
        return [
            'userSalutation' => $this->user->salutation,
            'userName'       => $this->user->first_name . ' ' . $this->user->last_name,
            'userEmail'      => $this->user->email,
            'age'            => $this->age(),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function age()
    {
        if ($this->birthday) {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $this->birthday)->age;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\Company');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function cartRules()
    {
        return $this->belongsToMany('App\Models\CartRule');
    }

    public function favorites()
    {
        return $this->belongsToMany('App\Models\Product', 'favorites', 'user_id', 'product_id');
    }

    public function locationSettings()
    {
        return $this->hasOne('App\Models\LocationSettings', 'id', 'location_settings_id');
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
    public function getBirthdayAttribute($value)
    {
        if ($value) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
        }
    }

}
