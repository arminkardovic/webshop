<?php
/**
 * Created by PhpStorm.
 * User: Armin
 * Date: 11.4.2019.
 * Time: 20:23
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index(Request $request, $category)
    {
        $category = Category::where("slug", "=", $category)->orWhere('slug_sr', '=', $category)->first();
        /** @var Category $category */
        if($category == null) {
            abort(404);
        }
        $products = $category->allProducts();

        $attributes = array();

        if($category->slug != 'gift-packets') {
            /** @var */
            $products->whereHas('prices', function ($q) use ($request) {

                $q->where('stock', '>', 0);

                foreach ($request->except('price') as $param) {
                    if ($param == 'all') continue;

                    $param = is_array($param) ? $param : [];
                    $param = array_map(function ($value) {
                        return intval($value);
                    }, $param);

                    $q->where(function ($q) use ($param) {
                        $i = 0;
                        foreach ($param as $attributeValueId) {
                            if ($i == 0) {
                                $q->whereRaw("JSON_CONTAINS(`product_prices`.`attributes`, '$attributeValueId')");
                            } else {
                                $q->orWhereRaw("JSON_CONTAINS(`product_prices`.`attributes`, '$attributeValueId')");
                            }
                            $i++;
                        }
                    });


                }
            });

            $attributes = Attribute::with('values')->whereHas('sets', function ($q) use ($category) {
                $q->where('id', $category->attribute_set_id);
            })->get();
        }

        if ($request->has('price')) {
            if ($request->get('price') == 'asc') {
                $products->orderBy('price', 'asc');
            } else {
                $products->orderBy('price', 'desc');
            }
        }

        $products = $products->paginate();


//        dd($products);

//        dd($products);



        return view("web.category.index", [
            "category" => $category,
            "products" => $products,
            "attributes" => $attributes,
            'old' => $request->all()
        ]);
    }
}