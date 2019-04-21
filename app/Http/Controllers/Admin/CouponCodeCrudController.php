<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CouponCodeRequest as StoreRequest;
use App\Http\Requests\CouponCodeRequest as UpdateRequest;

class CouponCodeCrudController extends CrudController
{

    public function setUp()
    {

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\CouponCode");
        $this->crud->setRoute("admin/coupon-codes");
        $this->crud->setEntityNameStrings('coupon', 'coupons');

        /*
        |--------------------------------------------------------------------------
        | BUTTONS
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name' => 'code',
                'label' => trans('coupon_code.code'),
            ],
            [
                'name' => 'discount',
                'label' => trans('coupon_code.discount'),
                'suffix' => '%'
            ]
        ]);

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |-------------------------------------------------------------------------
        */
        $this->setPermissions();

        /*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */
        $this->setFields();

        /*
        |--------------------------------------------------------------------------
        | AJAX TABLE VIEW
        |--------------------------------------------------------------------------
        */
        $this->crud->enableAjaxTable();

    }

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'update', 'delete']);

        // Allow list access
        if ($user->can('list_coupon_codes')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('create_coupon_codes')) {
            $this->crud->allowAccess('create');
        }

        // Allow update access
        if ($user->can('update_coupon_codes')) {
            $this->crud->allowAccess('update');
        }
        // Allow delete access
        if ($user->can('delete_coupon_codes')) {
            $this->crud->allowAccess('delete');
        }
    }

    public function setFields()
    {
        $this->crud->addFields([
            [
                'name' => 'code',
                'label' => trans('coupon_code.code'),
                'type' => 'text',
            ],
            [
                'name' => 'discount',
                'label' => trans('coupon_code.discount'),
                'type' => 'number',
                'suffix' => '%'
            ]
        ]);
    }

    public function store(StoreRequest $request)
    {
        $redirect_location = parent::storeCrud();

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud();

        return $redirect_location;
    }
}
