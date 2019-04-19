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
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends BaseController
{
    public function index(Request $request)
    {
        $cart = $this->getCartObject();

        return view('web.checkout.index', [
            'cart' => $cart
        ]);
    }

    public function previewWithCouponCode(Request $request)
    {
        $cart = $this->getCartObject();

        return view('web.checkout.index', [
            'cart' => $cart,
            'coupon' => (object)[
                'discount' => 10,
                'code' => 'G2359FJSAF62'
            ]
        ]);
    }

    public function getCollapseCartHtml(Request $request)
    {
        $cart = $this->getCartObject();
        return view('web.cart.collapse', [
            'cart' => $cart
        ]);
    }

    public function getCollapseInnerCartHtml(Request $request)
    {
        $cart = $this->getCartObject();
        return view('web.cart.collapse-inner', [
            'cart' => $cart
        ]);
    }

    private function getCartObject()
    {
        if (!Cookie::has('cart')) {
            return [];
        }

        $cart = Cookie::get('cart');
        $cart = json_decode($cart);

        $productIds = array();

        foreach ($cart as $item) {
            if (!in_array($item->product_id, $productIds)) {
                $productIds[] = $item->product_id;
            }
        }

        $attributeSetIds = array();

        $products = Product::findMany($productIds);

        foreach ($products as $product) {
            /** @var Product $product */
            if (!in_array($product->attribute_set_id, $attributeSetIds)) {
                $attributeSetIds[] = $product->attribute_set_id;
            }
        }

        $attributes = Attribute::with('values')->whereHas('sets', function ($q) use ($attributeSetIds) {
            $q->whereIn('id', $attributeSetIds);
        })->get();


        foreach ($cart as $key => $item) {
            $joinedCombination = '[' . join(', ', $item->combination) . ']';

            $price = ProductPrice::query()->whereRaw("CAST(`product_prices`.`attributes` as char) = '$joinedCombination'")->where('product_id', '=', $item->product_id)->first();

            $item->price = $price->price;
            $item->stock = $price->stock;
            $item->sku = $price->sku;
            $item->combinationInfo = array();

            foreach ($products as $product) {
                if ($product->id == $item->product_id) {
                    $item->product_name = $product->name;
                    $item->product_name_sr = $product->name_sr;
                    $item->featureImage = $product->featureImage;
                    break;
                }
            }

            foreach ($attributes as $attribute) {
                /** @var Attribute $attribute */
                foreach ($attribute->values as $value) {
                    foreach ($item->combination as $combinationItem) {
                        if ($combinationItem == $value->id) {
                            $combinationInfoItem = new \stdClass();
                            $combinationInfoItem->id = $value->id;
                            $combinationInfoItem->name = $attribute->name;
                            $combinationInfoItem->value = $value->value;
                            $item->combinationInfo[] = $combinationInfoItem;
                            break;
                        }
                    }
                }
            }

            $cart[$key] = $item;
        }

        return $cart;
    }


    /**
     * @return int|mixed
     */
    public function getCartTotal()
    {
        $cartTotal = 0;

        if (Cookie::has('cart')) {
            $cart = Cookie::get('cart');
            $cart = json_decode($cart);

            foreach ($cart as $item) {
                $joinedCombination = '[' . join(', ', $item->combination) . ']';

                $price = ProductPrice::query()->whereRaw("CAST(`product_prices`.`attributes` as char) = '$joinedCombination'")->where('product_id', '=', $item->product_id)->first();

                $cartTotal += $price->price * $item->quantity;
            }
        }

        return $cartTotal;
    }


    public function makeOrder(Request $request)
    {
        $cart = $this->getCartObject();

        $orderItems = array();
        $shippingPrice = 20.00;
        $totalPrice = 0;

        foreach ($cart as $item) {
            if ($item->quantity > $item->stock) {
                return back()->with('warning', 'One of the items has ran out of stock.');
            }

            $attributes = array();

            foreach ($item->combinationInfo as $combinationInfoItem) {
                $attribute = array();
                $attribute['name'] = $combinationInfoItem->name;
                $attribute['value'] = $combinationInfoItem->value;
                $attributes[] = $attribute;
            }

            $orderItems[] = [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'sku' => $item->sku,
                'name' => $item->product_name,
                'name_sr' => $item->product_name_sr,
                'attributes'    => json_encode($attributes)
            ];

            $totalPrice += $item->price * $item->quantity;
        }

        $order = new Order([
            'status_id' => 1,
        ]);
        $order->user_id = 1;
        $order->carrier_id = 1;
        $order->currency_id = 1;
        $order->total = $totalPrice;
        $order->total_shipping = $shippingPrice;
        $order->save();

        foreach($orderItems as $key => $item) {
            $item['order_id'] = $order->id;
            $orderItems[$key] = $item;
        }

        OrderItem::insert($orderItems);

        $cookie = Cookie::forget('cart');

        return back()->with('message', 'Congratulations! An order has been made.')->withCookie($cookie);
    }
}