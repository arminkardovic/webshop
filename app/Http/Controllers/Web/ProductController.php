<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $attributes = Attribute::with('values')->whereHas('sets', function ($q) use ($product) {
            $q->where('id', $product->attribute_set_id);
        })->get();

        return view("web.product.single", [
            "product" => $product,
            'attributes' => $attributes
        ]);
    }
}