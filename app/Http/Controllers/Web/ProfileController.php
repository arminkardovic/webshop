<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 11.4.2019.
 * Time: 20:23
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProfileController extends BaseController
{
    public function index(Request $request)
    {
        $user = \Auth::user();
        return view("web.profile.index", [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = \Auth::user();
        $attributes = $request->except('password');
        if($request->has('password')) {
            $password = bcrypt($request->get('password'));
            $attributes['password'] = $password;
        }
        $user->fill($attributes);

        try {
            $user->save();
        }catch (\Exception $exception) {
            return redirect('/profile')->with('warning', 'Email already in use.');
        }

        return redirect('/profile')->with('message', 'Successfully updated profile info.');
    }
}