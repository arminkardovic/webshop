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

    public function getInfoForCombination(Request $request)
    {
        $id = $request->get('product_id');
        $combination = json_decode($request->get('combination'));

        $attributeValueIds = array();

        foreach ($combination as $item) {
            $attributeValueIds[] = (int)$item->value;
        }

        $product = Product::findOrFail($id);
        $attributes = Attribute::with('values')->whereHas('sets', function ($q) use ($product) {
            $q->where('id', $product->attribute_set_id);
        })->get();

        sort($attributeValueIds);
        $attributeValueIds = '[' . join(', ', $attributeValueIds) . ']';


        $productPrice = ProductPrice::query()->where('product_id', '=', $id)->whereRaw("CAST(`product_prices`.`attributes` as char) = '$attributeValueIds'")->first();


        return view("web.product.info", [
            "product" => $product,
            'attributes' => $attributes,
            "productPrice" => $productPrice
        ]);
    }

    public function addToCart(Request $request, CookieJar $cookieJar)
    {
        $productId = $request->get('product_id');
        $combination = $request->get('combination');
        $quantity = $request->get('quantity');
        sort($combination);

        $attributeValueIds = '[' . join(', ', $combination) . ']';

        $productPrice = ProductPrice::query()->where('product_id', '=', $productId)->whereRaw("CAST(`product_prices`.`attributes` as char) = '$attributeValueIds'")->first();

        $encrypter = app(\Illuminate\Contracts\Encryption\Encrypter::class);


        $cart = array();

        if(Cookie::has('cart')) {
            $cartCookie = $encrypter->decrypt(Cookie::get('cart'));
            $cart = json_decode($cartCookie);
        }

        $alreadyInCart = false;

        foreach($cart as $key => $item) {
            if($item->product_id == $productId && $item->combination == $combination) {
                $item->quantity += $quantity;
                $cart[$key] = $item;
                $alreadyInCart = true;

                if($productPrice->stock < $item->quantity) {
                    return response('', 400);
                }
            }
        }

        if($alreadyInCart == false) {
            $cart[] = [
                'product_id' => $productId,
                'quantity' => $quantity,
                'combination' => $combination
            ];

            if($productPrice->stock < $quantity) {
                return response('', 400);
            }
        }


        $cookieJar->queue(cookie('cart', json_encode($cart), 30));

        return $encrypter->encrypt(json_encode($cart));

    }
}