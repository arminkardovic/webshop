<?php

namespace App\Http\Middleware;

use App;
use App\Models\LocationSettings;
use App\Models\Product;
use App\Models\ProductPrice;
use App\User;
use App\Utils\PriceUtils;
use Auth;
use Closure;
use Cookie;
use Torann\GeoIP\Facades\GeoIP;
use View;

class LocationSettingsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->setLanguage();
        if(!Auth::guest()) {
            View::share([
                'cartTotal' => $this->getCartTotal()
            ]);
        }
        return $next($request);
    }


    public function setLanguage()
    {
        $user = Auth::user();

        /** @var User $user */

        if ($user) {

            if (!isset($user->location_settings_id)) {
                $locationSettings = $this->getLocationSettingsByIp();
                $user->location_settings_id = $locationSettings->id;
                $user->save();
            }

            $locale = $user->locationSettings->locale;
        } else {
            $locationSettings = $this->getLocationSettingsByIp();
            $locale = $locationSettings->locale;
        }

        App::setLocale($locale);
    }

    /**
     * @return mixed
     */
    private function getLocationSettingsByIp()
    {
        $ip = \Request::ip();
//        $ip = '37.0.66.201';
        $geo = GeoIP::getLocation($ip);
        $country = $geo['country'];

        if ($country == null) {
            $country = 'United States';
        }

        $locationSettings = LocationSettings::where('country', $country)->first();
        return $locationSettings;
    }

    /**
     * @return int|mixed
     */
    private function getCartTotal() {
        $cartTotal = 0;

        if (Cookie::has('cart')) {
            $cart = Cookie::get('cart');
            $cart = json_decode($cart);

            foreach ($cart as $item) {
                if(isset($item->email)) {
                    $cartTotal += Product::findOrFail($item->product_id)->price;
                }else{
                    $joinedCombination = '[' . join(', ', $item->combination) . ']';

                    $price = ProductPrice::query()->whereRaw("CAST(`product_prices`.`attributes` as char) = '$joinedCombination'")->where('product_id', '=', $item->product_id)->first();

                    $cartTotal += $price->price * $item->quantity;
                }
            }
        }

        return PriceUtils::formattedPrice($cartTotal);
    }
}
