<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    public function getInfoForCombination(Request $request)
    {
        $id = $request->get('product_id');
        $combination = json_decode($request->get('combination'));

        $attributeValueIds = array();

        foreach ($combination as $item) {
            $attributeValueIds[] = (int) $item->value;
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