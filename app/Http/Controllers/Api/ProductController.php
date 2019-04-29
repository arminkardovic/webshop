<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductPrice;
use http\Env\Response;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class ProductController extends BaseController
{


    public function addToCart(Request $request, CookieJar $cookieJar)
    {
        $productId = $request->get('product_id');
        $quantity = $request->get('quantity');

        if ($request->has('from')) {
            $from = $request->get('from');
            $message = $request->get('message');

            $encrypter = app(\Illuminate\Contracts\Encryption\Encrypter::class);


            $cart = array();

            if (Cookie::has('cart')) {
                $cartCookie = $encrypter->decrypt(Cookie::get('cart'));
                $cart = json_decode($cartCookie);
            }


            $cart[] = [
                'product_id' => $productId,
                'quantity' => $quantity,
                'from' => $from,
                'message' => $message
            ];


            $cookieJar->queue(cookie('cart', json_encode($cart), 30));

            return $encrypter->encrypt(json_encode($cart));


        } else {
            $combination = $request->get('combination');
            sort($combination);

            $attributeValueIds = '[' . join(', ', $combination) . ']';

            $productPrice = ProductPrice::query()->where('product_id', '=', $productId)->whereRaw("CAST(`product_prices`.`attributes` as char) = '$attributeValueIds'")->first();

            $encrypter = app(\Illuminate\Contracts\Encryption\Encrypter::class);


            $cart = array();

            if (Cookie::has('cart')) {
                $cartCookie = $encrypter->decrypt(Cookie::get('cart'));
                $cart = json_decode($cartCookie);
            }

            $alreadyInCart = false;

            foreach ($cart as $key => $item) {
                if ($item->product_id == $productId && $item->combination == $combination) {
                    $item->quantity += $quantity;
                    $cart[$key] = $item;
                    $alreadyInCart = true;

                    if ($productPrice->stock < $item->quantity) {
                        return response('', 400);
                    }
                }
            }

            if ($alreadyInCart == false) {
                $cart[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'combination' => $combination
                ];

                if ($productPrice->stock < $quantity) {
                    return response('', 400);
                }
            }


            $cookieJar->queue(cookie('cart', json_encode($cart), 30));

            return $encrypter->encrypt(json_encode($cart));
        }


    }

    public function removeFromCart(Request $request, CookieJar $cookieJar)
    {
        $item = json_decode($request->get('item'));

        $encrypter = app(\Illuminate\Contracts\Encryption\Encrypter::class);

        $cart = array();

        if (Cookie::has('cart')) {
            $cartCookie = $encrypter->decrypt(Cookie::get('cart'));
            $cart = json_decode($cartCookie);
        }


        if (!$item->gift) {
            $combinationIds = array();

            foreach ($item->combinationInfo as $combinationItem) {
                $combinationIds[] = $combinationItem->id;
            }
        }

        foreach ($cart as $key => $currentItem) {
            if ($currentItem->product_id == $item->product_id) {
                if ($item->gift && $item->email == $currentItem->email) {
                    unset($cart[$key]);
                    $cart = array_values($cart);
                    break;
                } else if (!$item->gift && $currentItem->combination == $combinationIds) {
                    unset($cart[$key]);
                    $cart = array_values($cart);
                    break;
                }
            }
        }


        $cookieJar->queue(cookie('cart', json_encode($cart), 30));

        return $encrypter->encrypt(json_encode($cart));

    }

}