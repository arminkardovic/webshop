<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AttributeRequest as StoreRequest;
use App\Http\Requests\AttributeUpdateRequest as UpdateRequest;
use App\Models\AttributeValue;
use App\Models\LocationSettings;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;

class ExchangeRatesController extends BaseController
{

    public function index(Request $request)
    {
        $usdExchange = LocationSettings::where('currency', '=', 'USD')->limit(1)->pluck('exchange_rate')->first();
        $rsdExchange = LocationSettings::where('currency', '=', 'RSD')->limit(1)->pluck('exchange_rate')->first();

        return view('admin.currency.index', [
            'usdExchange' => $usdExchange,
            'rsdExchange' => $rsdExchange
        ]);
    }

    public function update(Request $request)
    {
        $usdExchange = $request->get('usdExchange');
        $rsdExchange = $request->get('rsdExchange');

        LocationSettings::where('currency', '=', 'USD')->update(['exchange_rate' => $usdExchange]);
        LocationSettings::where('currency', '=', 'RSD')->update(['exchange_rate' => $rsdExchange]);


        return view('admin.currency.index', [
            'usdExchange' => $usdExchange,
            'rsdExchange' => $rsdExchange
        ]);
    }

}
