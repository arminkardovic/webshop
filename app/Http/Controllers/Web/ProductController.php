<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 11.4.2019.
 * Time: 20:23
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        return view("web.product.single", [
            "product" => $product
        ]);
    }
}