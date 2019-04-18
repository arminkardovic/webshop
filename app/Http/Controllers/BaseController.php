<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 11.4.2019.
 * Time: 19:59
 */

namespace App\Http\Controllers;

use App\Models\ProductPrice;
use Backpack\MenuCRUD\app\Models\MenuItem;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;


class BaseController extends Controller
{
    public function __construct()
    {
        $menuItems = MenuItem::all();

        View::share([
            'menuItems' => $menuItems,
            'cartTotal' => $this->getCartTotal()
        ]);
    }

    /**
     * @return int|mixed
     */
    private function getCartTotal() {
        $cartTotal = 0;

        if (Cookie::has('cart')) {
            $encrypter = app(\Illuminate\Contracts\Encryption\Encrypter::class);
            $cart = $encrypter->decrypt(Cookie::get('cart'));
            $cart = json_decode($cart);

            foreach ($cart as $item) {
                $joinedCombination = '[' . join(', ', $item->combination) . ']';

                $price = ProductPrice::query()->whereRaw("CAST(`product_prices`.`attributes` as char) = '$joinedCombination'")->where('product_id', '=', $item->product_id)->first();

                $cartTotal += $price->price * $item->quantity;
            }
        }

        return $cartTotal;
    }
}