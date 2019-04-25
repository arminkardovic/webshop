<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(Request $request, $id,  CookieJar $cookieJar)
    {


        $product = Product::findOrFail($id);

        if($product->gift) {
            return view("web.product.gift", [
                "product" => $product
            ]);
        }

        $attributes = Attribute::with('values')->whereHas('sets', function ($q) use ($product) {
            $q->where('id', $product->attribute_set_id);
        })->get();

        return view("web.product.single", [
            "product" => $product,
            'attributes' => $attributes
        ]);
    }


    public function addToFavorites(Request $request) {
        $productId = $request->get('product_id');
        \Auth::user()->favorites()->attach($productId);
    }

    public function removeFromFavorites (Request $request) {
        $productId = $request->get('product_id');
        \Auth::user()->favorites()->detach($productId);
    }

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
}