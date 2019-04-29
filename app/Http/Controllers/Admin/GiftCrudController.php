<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GiftRequest as StoreRequest;
use App\Http\Requests\GiftRequest as UpdateRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ProductImage;
use App\Models\Tax;
use App\Models\SpecificPrice;
use App\Models\ProductPrice;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GiftCrudController extends CrudController
{

    public function setUp()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("App\Models\Product");
        $this->crud->setRoute("admin/gifts");
        $this->crud->setEntityNameStrings('gift', 'gifts');


        $this->crud->addClause('where', 'gift', '=', '1');

        /*
        |--------------------------------------------------------------------------
        | BUTTONS
        |--------------------------------------------------------------------------
        | See setPermissions method
        */

        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => trans('product.name'),
            ],
            /*[
                'type' => "select_multiple",
                'label' => trans('category.categories'),
                'name' => 'categories',
                'entity' => 'categories',
                'attribute' => "name",
                'model' => "App\Models\Category",
            ],*/
            [
                'name' => 'price',
                'label' => trans('product.price'),
            ],
            [
                'name' => 'active',
                'label' => trans('common.status'),
                'type' => 'boolean',
                'options' => [
                    0 => trans('common.inactive'),
                    1 => trans('common.active')
                ],
            ]
        ]);

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |-------------------------------------------------------------------------
        */
        $this->setPermissions();

        /*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */
        $this->setFields();

        /*
        |--------------------------------------------------------------------------
        | AJAX TABLE VIEW
        |--------------------------------------------------------------------------
        */
        $this->crud->enableAjaxTable();

    }

    public function setPermissions()
    {
        // Get authenticated user
        $user = auth()->user();

        // Deny all accesses
        $this->crud->denyAccess(['list', 'create', 'update', 'delete']);

        // Allow list access
        if ($user->can('list_products')) {
            $this->crud->allowAccess('list');
        }

        // Allow create access
        if ($user->can('create_product')) {
            $this->crud->allowAccess('create');
        }

        // Allow update access
        if ($user->can('update_product')) {
            $this->crud->allowAccess('update');
        }

        // Allow clone access
        if ($user->can('clone_product')) {
            $this->crud->addButtonFromView('line', trans('product.clone'), 'clone_product', 'end');
        }

        // Allow delete access
        if ($user->can('delete_product')) {
            $this->crud->allowAccess('delete');
        }
    }

    public function setFields()
    {
        $this->crud->addFields([

/*            [
                'name' => 'sku',
                'label' => trans('product.sku'),
                'type' => 'text',
                'attributes' => [
                    'disabled' => 'disabled',
                ],
                // TAB
                'tab' => trans('product.general_tab'),
            ],*/

            [
                'name' => 'name',
                'label' => trans('product.name'),
                'type' => 'text',
                'tab' => trans('product.general_tab')
            ],
            [
                'name' => 'name_sr',
                'label' => trans('product.name_sr'),
                'type' => 'text',
                'tab' => trans('product.general_tab')
            ],
            [
                'name' => 'description',
                'label' => trans('product.description'),
                // 'type'  => 'ckeditor',
                'type' => 'ckeditor',
                // optional:
                'options' => [
                    'autoGrow_minHeight' => 200,
                    'autoGrow_bottomSpace' => 50,
                    'removePlugins' => 'resize,maximize',
                ],
                'tab' => trans('product.general_tab')
            ],
            [
                'name' => 'description_sr',
                'label' => trans('product.description_sr'),
                // 'type'  => 'ckeditor',
                'type' => 'ckeditor',
                // optional:
                'options' => [
                    'autoGrow_minHeight' => 200,
                    'autoGrow_bottomSpace' => 50,
                    'removePlugins' => 'resize,maximize',
                ],
                'tab' => trans('product.general_tab')
            ],
            [
                'label' => trans('category.category'),
                'type' => "select2_from_ajax",
                'name' => 'category_id', // the column that contains the ID of that connected entity
                'entity' => 'category', // the method that defines the relationship in your Model
                'attribute' => "name", // foreign key attribute that is shown to user
                'model' => "App\Models\Category", // foreign key model
                'data_source' => route("categories-ajax"), // url to controller search function (with /{id} should return model)
                'tab' => trans('product.general_tab'),
                'placeholder' => trans( 'product.hint_category'),
                'minimum_input_length' => 0
            ],
            [
                'name' => 'price_with_vat',
                'label' => trans('product.price'),
                'type' => 'number',
                'attributes' => [
                    'step' => 'any',
                ],

                // TAB
                'tab' => trans('product.price_tab'),
            ],


            [
                'name' => 'price',
                'label' => trans('product.price_without_vat'),
                'type' => 'text',
                'attributes' => [
                    'readonly' => 'readonly',
                ],

                // TAB
                'tab' => trans('product.price_tab'),
            ],

            [
                'name' => 'price_vat_calculator',
                'type' => 'product_vat',
                'tab' => trans('product.price_tab'),

            ],
            [
                'type' => 'select2_tax',
                'label' => trans('tax.tax'),
                'name' => 'tax_id',
                'entity' => 'tax',
                'attribute' => 'name',
                'data_value' => 'value',
                'model' => "App\Models\Tax",
                'attributes' => [
                    'id' => 'tax',
                ],
                'tab' => trans('product.price_tab')
            ],


            /** END PRICE */

            [
                'name' => 'active',
                'label' => trans('common.status'),
                'type' => 'select_from_array',
                'options' => [
                    '0' => trans('common.inactive'),
                    '1' => trans('common.active'),
                ],
                'tab' => trans('product.general_tab')
            ]
        ]);

        $this->crud->addField([
            'name' => 'dropzone',
            'type' => 'dropzone',
            'disk' => 'products', // disk where images will be uploaded
            'mimes' => [
                'image/*'
            ],
            'filesize' => 5, // maximum file size in MB

            // TAB
            'tab' => trans('product.product_images_tab')
        ], 'update');



    }

    public function ajaxUploadProductImages(Request $request, Product $product)
    {
        $images = [];
        $disk = "products";

        if ($request->file && $request->id) {
            $product = $product->find($request->id);
            $productImages = $product->images->toArray();

            if ($productImages) {
                $ord = count($productImages);
            } else {
                $ord = 0;
            }

            foreach ($request->file as $file) {
                $file_content = file_get_contents($file);
                $path = substr($product->id, 0, 1) . DIRECTORY_SEPARATOR . $product->id . DIRECTORY_SEPARATOR;
                $filename = md5(uniqid('', true)) . '.' . $file->extension();

                Storage::disk($disk)->put($path . $filename, $file_content);

                $images[] = [
                    'product_id' => $product->id,
                    'name' => $filename,
                    'order' => $ord++
                ];
            }

            $product->images()->insert($images);

            return response()->json($product->load('images')->images->toArray());
        }
    }

    public function ajaxReorderProductImages(Request $request, ProductImage $productImage)
    {
        if ($request->order) {
            foreach ($request->order as $position => $id) {
                $productImage->find($id)->update(['order' => $position]);
            }
        }
    }

    public function ajaxDeleteProductImage(Request $request, ProductImage $productImage)
    {
        $disk = "products";

        if ($request->id) {
            $productImage = $productImage->find($request->id);

            if (Storage::disk($disk)->has($productImage->name)) {
                if (Storage::disk($disk)->delete($productImage->name)) {
                    $productImage->delete();

                    return response()->json(['success' => true, 'message' => trans('product.image_deleted')]);
                }
            }

            return response()->json(['success' => false, 'message' => trans('product.image_not_found')]);
        }
    }

    public function store(StoreRequest $request, ProductGroup $productGroup, SpecificPrice $specificPrice)
    {

        $productGroup = $productGroup->create();

        $category = Category::where('slug', 'gift-packets')->first();

        $request->merge([
            'group_id' => $productGroup->id,
            'category_id' => $category->id,
            'subcategory_id' => $category->id,
            'weight' => 100,
            'gift'  => 1
        ]);



        $redirect_location = parent::storeCrud($request);

        // Save product's attribute values
        if ($request->input('attributes')) {
            foreach ($request->input('attributes') as $key => $attr_value) {
                if (is_array($attr_value)) {
                    foreach ($attr_value as $value) {
                        $this->crud->entry->attributes()->attach([$key => ['value' => $value]]);
                    }
                } else {
                    $this->crud->entry->attributes()->attach([$key => ['value' => $attr_value]]);
                }
            }
        }


        $productId = $this->crud->entry->id;

        $product = Product::find($productId); /** @var Product $product */


        $reduction = $request->input('reduction');
        $discountType = $request->input('discount_type');
        $startDate = $request->input('start_date');
        $expirationDate = $request->input('expiration_date');

        if (!$request->has('start_date') || !$request->has('expiration_date')) {
            \Alert::error(trans('specificprice.dates_cant_be_null'))->flash();
            return $redirect_location;
        }

        // Check if a specific price reduction doesn't already exist in this period
        if (!$this->validateProductDates($productId, $startDate, $expirationDate)) {
            $productName = $product->name;

            \Alert::error(trans('specificprice.wrong_dates', ['productName' => $productName]))->flash();
            return $redirect_location;
        }

        // Check if the price after reduction is not less than 0
        if ($request->has('reduction') && $request->has('discount_type')) {
            if (!$this->validateReductionPrice($productId, $reduction,
                $discountType)) {
                \Alert::error(
                    trans('specificprice.reduction_price_not_ok'))->flash();
            } else {
                // Save specific price
                $specificPrice->discount_type = $discountType;
                $specificPrice->reduction = $reduction;
                $specificPrice->start_date = $startDate;
                $specificPrice->expiration_date = $expirationDate;
                $specificPrice->product_id = $productId;
                $specificPrice = $specificPrice->save();
            }
        }

        return $redirect_location;
    }


    public function update(UpdateRequest $request, Attribute $attribute, Product $product)
    {
        // Get current product data
        $id = $this->crud->request->id;
        $product = $product->findOrFail($id);

        $sizes = AttributeValue::query()->whereHas('attribute', function ($query) {
            $query->where('name', '=', 'Size');
        })->get();

        $colors = AttributeValue::query()->whereHas('attribute', function ($query) {
            $query->where('name', '=', 'Color');
        })->get();

        $redirect_location = parent::updateCrud($request);

        // Add product attributes ids and values in attribute_product_value (pivot)

        //update product prices
        ProductPrice::where("product_id", "=", $id)->delete();
        $productPrices = json_decode($request->get('productPricesField'));

        $sku = sprintf('%01d', $product->category_id);
        $sku .= sprintf('%02d', $product->subcategory_id);
        $sku .= sprintf('%04d', $product->id);

        foreach ($productPrices as $productPrice) {
            $sizeCode = '00';
            $colorCode = '00';

            foreach ($productPrice->attributeValuesIds as $attributeValue) {
                foreach ($colors as $color) {
                    if($color->id == $attributeValue) {
                        $colorCode = sprintf('%02d', $color->id);
                    }
                }

                foreach ($sizes as $size) {
                    if($size->id == $attributeValue) {
                        $sizeCode = sprintf('%02d', $size->id);
                    }
                }
            }

            sort($productPrice->attributeValuesIds);
            $productPriceToSave = new ProductPrice([
                'product_id' => $id,
                'stock' => $productPrice->stock,
                'price' => $productPrice->price,
                'attributes' => $productPrice->attributeValuesIds,
                'sku' => $sku . $sizeCode . $colorCode
            ]);
            $productPriceToSave->save();
        }


        if ($request->input('attributes')) {

            // Set attributes upload disk
            $disk = 'attributes';

            // Get old product atrribute values
            $oldAttributes = [];

            foreach ($this->crud->entry->attributes as $oldAttribute) {
                $oldAttributes[$oldAttribute->id] = $oldAttribute->pivot->value;
            }

            // Check if attribute set was changed and delete uploaded data from disk on attribute type media
            if ($product->attribute_set_id != $this->crud->request->attribute_set_id) {
                foreach ($oldAttributes as $key => $oldAttribute) {
                    if (\Storage::disk($disk)->has($oldAttribute) && $attribute->find($key)->values->first()->value != $oldAttribute) {
                        \Storage::disk($disk)->delete($oldAttribute);
                    }
                }
            }

            $this->crud->entry->attributes()->detach();

            foreach ($request->input('attributes') as $key => $attr_value) {
                if (is_array($attr_value)) {
                    foreach ($attr_value as $value) {
                        $this->crud->entry->attributes()->attach([$key => ['value' => $value]]);
                    }
                } else {
                    if (starts_with($attr_value, 'data:image')) {
                        // 1. Delete old image
                        if ($product->attribute_set_id == $this->crud->request->attribute_set_id) {
                            if (\Storage::disk($disk)->has($oldAttributes[$key]) && $attribute->find($key)->values->first()->value != $oldAttributes[$key]) {
                                \Storage::disk($disk)->delete($oldAttributes[$key]);
                            }
                        }
                        // 2. Make the image
                        $image = \Image::make($attr_value);
                        // 3. Generate a filename.
                        $filename = md5($attr_value . time()) . '.jpg';
                        // 4. Store the image on disk.
                        \Storage::disk($disk)->put($filename, $image->stream());
                        // 5. Update image filename to attributes_value
                        $attr_value = $filename;
                    }

                    $this->crud->entry->attributes()->attach([$key => ['value' => $attr_value]]);
                }
            }
        }


        $discountType = $request->input('discount_type');
        $reduction = $request->input('reduction');
        $startDate = $request->input('start_date');
        $expirationDate = $request->input('expiration_date');
        $productId = $this->crud->entry->id;


        // Check if the price after reduction is not less than 0
        if ($request->reduction && $request->discount_type && $discountType) {
            if (!$this->validateReductionPrice($productId, $reduction,
                $discountType)) {
                \Alert::error(
                    trans('specificprice.reduction_price_not_ok'))->flash();
                return $redirect_location;
            }
        }

        // Check if a specific price reduction doesn't already exist in this period
        if (!$this->validateProductDates($productId, $startDate, $expirationDate)) {
            $product = Product::find($productId);
            $productName = $product->name;

            \Alert::error(trans('specificprice.wrong_dates', ['productName' => $productName]))->flash();
            return $redirect_location;
        }

        if ($request->reduction && $request->discount_type && $discountType) {
            if (!$request->start_date || !$request->expiration_date) {
                \Alert::error(trans('specificprice.dates_cant_be_null'))->flash();
                return $redirect_location;
            }

            // Save specific price
            $specificPrice = new SpecificPrice();

            $specificPrice->discount_type = $discountType;
            $specificPrice->reduction = $reduction;
            $specificPrice->start_date = $startDate;
            $specificPrice->expiration_date = $expirationDate;
            $specificPrice->product_id = $productId;
            $specificPrice = $specificPrice->save();
        }


        return $redirect_location;
    }

    /**
     * @param Product $product
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function cloneProduct(Product $product, Request $request)
    {
        $id = $request->input('product_id');
        $cloneSku = $request->input('clone_sku');
        $cloneImages = $request->input('clone_images');

        // Check if cloned product has sku
        if (!$cloneSku) {
            \Alert::error(trans('product.sku_required'))->flash();

            return redirect()->back();
        }

        // Check if product sku exist
        if ($product->where('sku', $cloneSku)->first()) {
            \Alert::error(trans('product.sku_unique'))->flash();

            return redirect()->back();
        }

        // Prepare relations
        $relations = ['categories', 'attributes'];

        if ($cloneImages) {
            array_push($relations, 'images');
        }

        // Find product and load relations specified
        $product = $product->with($relations)->find($id);

        // Redirect back if product what need to be cloned doesn't exist
        if (!$product) {
            \Alert::error(trans('product.cannot_find_product'))->flash();

            return redirect()->back();
        }

        // Create clone object
        $clone = $product->replicate();
        $clone->sku = $cloneSku;

        // Save cloned product
        $clone->push();

        // Clone product relations
        foreach ($product->getRelations() as $relationName => $values) {
            $relationType = getRelationType($product->{$relationName}());

            switch ($relationType) {
                case 'hasMany':
                    if (count($product->{$relationName}) > 0) {
                        foreach ($product->{$relationName} as $relationValue) {
                            $values = $relationValue->toArray();

                            // skip image name accessor
                            if ($relationName === "images") {
                                $values['name'] = $relationValue->getOriginal('name');
                            }

                            $clone->{$relationName}()->create($values);
                        }
                    }
                    break;

                case 'hasOne':
                    if ($product->{$relationName}) {
                        $clone->{$relationName}()->create($values->toArray());
                    }
                    break;

                case 'belongsToMany':
                    $clone->{$relationName}()->sync($values);
                    break;
            }
        }

        // clone images on disk
        if ($cloneImages) {
            foreach ($product->images as $image) {
                $newpath = substr($clone->id, 0, 1) . DIRECTORY_SEPARATOR . $clone->id . DIRECTORY_SEPARATOR;

                Storage::disk('products')->copy($image->name, $newpath . $image->getOriginal('name'));
            }
        }

        \Alert::success(trans('product.clone_success'))->flash();

        return redirect()->back();
    }

    /**
     * Validate if the price after reduction is not less than 0
     *
     * @return boolean
     */
    public function validateReductionPrice($productId, $reduction,
                                           $discountType)
    {

        $product = Product::find($productId);
        $oldPrice = $product->price;
        if ($discountType == 'Amount') {
            $newPrice = $oldPrice - $reduction;
        }
        if ($discountType == 'Percent') {
            $newPrice = $oldPrice - $reduction / 100.00 * $oldPrice;
        }

        if ($newPrice < 0) {
            return false;
        }
        return true;
    }

    /**
     * Check if it doesn't already exist a specific price reduction for the same
     * period for a product
     *
     * @return boolean
     */
    public function validateProductDates($productId, $startDate, $expirationDate)
    {
        $specificPrice = SpecificPrice::where('product_id', $productId)->get();

        foreach ($specificPrice as $item) {
            $existingStartDate = $item->start_date;
            $existingExpirationDate = $item->expiration_date;
            if ($expirationDate >= $existingStartDate
                && $startDate <= $existingExpirationDate) {
                return false;
            }
            if ($expirationDate >= $existingStartDate
                && $startDate <= $existingExpirationDate) {
                return false;
            }
            if ($startDate <= $existingStartDate
                && $expirationDate >= $existingExpirationDate) {
                return false;
            }
        }

        return true;
    }

    public function getCreateProductPricesTable(Request $request, Attribute $attribute)
    {

        $attributes = $attribute->with('values')->whereHas('sets', function ($q) use ($request) {
            $q->where('id', $request->setId);
        })->get();

        $numberOfCombinations = 1;

        foreach ($attributes as $attribute) {
            $numberOfCombinations *= count($attribute->values);
        }


        $combinations = array();
        for ($i = 0; $i < $numberOfCombinations; $i++) {
            $combinations[$i] = array();
        }


        $order = 0;

        $repeatCount = $numberOfCombinations;

        foreach ($attributes as $attribute) {

            $repeatCount = $repeatCount / count($attribute->values);

            for ($i = 0; $i < $numberOfCombinations; $i++) {
                $valueIndex = (int)floor(($i / $repeatCount) % count($attribute->values));
                $combinations[$i][$order] = $attribute->values->toArray()[$valueIndex];
            }

            $order++;
        }

        return view('renders.product_create_prices', compact('combinations', 'attributes'));
    }

    public function getUpdateProductPricesTable(Request $request, Attribute $attribute)
    {

        $attributes = $attribute->with('values')->whereHas('sets', function ($q) use ($request) {
            $q->where('id', $request->setId);
        })->get();

        $numberOfCombinations = 1;

        foreach ($attributes as $attribute) {
            $numberOfCombinations *= count($attribute->values);
        }


        $combinations = array();
        for ($i = 0; $i < $numberOfCombinations; $i++) {
            $combinations[$i] = new \stdClass();
            $combinations[$i]->combinations = array();
            $combinations[$i]->stock = 0;
            $combinations[$i]->price = 0;
        }


        $order = 0;

        $repeatCount = $numberOfCombinations;


        $product = Product::findOrFail($request->get('productId'));
        /** @var Product $product */

        if ($product->attribute_set_id == $request->setId) {
            $oldPrices = $product->prices;
        }

        foreach ($attributes as $attribute) {

            $repeatCount = $repeatCount / count($attribute->values);

            for ($i = 0; $i < $numberOfCombinations; $i++) {
                $valueIndex = (int)floor(($i / $repeatCount) % count($attribute->values));
                $combinations[$i]->combinations[$order] = $attribute->values->toArray()[$valueIndex];

                if ($product->attribute_set_id == $request->setId) {

                    foreach ($oldPrices as $oldPrice) {
                        /** @var ProductPrice $oldPrice */
                        $combinationIds = array();
                        foreach ($combinations[$i]->combinations as $combination) {
                            $combinationIds[] = $combination['id'];
                        }

                        if (!array_diff($oldPrice->attributes, $combinationIds) && !array_diff($combinationIds, $oldPrice->attributes)) {
                            $combinations[$i]->stock = $oldPrice->stock;
                            $combinations[$i]->price = $oldPrice->price;
                        }
                    }
                }
            }

            $order++;
        }


        return view('renders.product_update_prices', compact('combinations', 'attributes'));
    }
}



