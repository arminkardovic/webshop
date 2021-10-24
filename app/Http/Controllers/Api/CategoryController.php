<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function categoriesAjax(Request $request)
    {
        $q = $request->get('q');
        $categories = Category::where('parent_id', '=', 0)->where('name', 'like', "$q%")->paginate();
        return response()->json($categories);
    }

    public function subcategoriesAjax(Request $request)
    {
        $q = $request->get('q');
        $categories = Category::where('parent_id', '=', $request->get('parent_id'))->where('name', 'like', "$q%")->paginate();
        return response()->json($categories);
    }
}