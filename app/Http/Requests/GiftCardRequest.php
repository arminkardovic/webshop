<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GiftCardRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'buyer_full_name'  => 'required',
            'message'          => 'required',
            'card_code'        => 'required',
            'card_value'       => 'required|numeric|between:0,9999999999999.999999',
            'spent_value'      => 'required|numeric|between:0,9999999999999.999999'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
