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
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index(Request $request, $category)
    {
        $category = Category::where("slug", "=", $category)->first();
        $products = $category->products()->paginate();
        return view("web.category.index", [
            "category" => $category,
            "products" => $products
        ]);
    }
}