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
use App\Models\CouponCode;
use App\Models\LocationSettings;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Notifications\OrderCreated;
use App\Notifications\OrderCreatedAdmin;
use App\User;
use App\Utils\PriceUtils;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends BaseController
{
    public function index(Request $request)
    {
        $cart = $this->getCartObject();
        $countries = LocationSettings::query()->orderBy('country')->get();

        return view('web.checkout.index', [
            'cart' => $cart,
            'countries' => $countries
        ]);
    }

    public function previewWithCouponCode(Request $request)
    {
        $cart = $this->getCartObject();

        $code = $request->get('couponcode');

        $coupon = CouponCode::where('code', $code)->first();

        if ($coupon == null) {
            return view('web.checkout.index', [
                'cart' => $cart,
                'couponWarning' => 'Coupon not found.'
            ]);
        }

        return view('web.checkout.index', [
            'cart' => $cart,
            'coupon' => $coupon
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
            foreach ($products as $product) {
                if ($product->id == $item->product_id) {
                    $item->product_name = $product->name;
                    $item->product_name_sr = $product->name_sr;
                    $item->featureImage = $product->featureImage;
                    $item->gift = $product->gift;
                    if ($item->gift) {
                        $item->price = $product->price;
                        $item->stock = 1;
                        $item->sku = '00000000000';
                    }
                    break;
                }
            }

            if (!$item->gift) {
                $joinedCombination = '[' . join(', ', $item->combination) . ']';


                $price = ProductPrice::query()->whereRaw("CAST(`product_prices`.`attributes` as char) = '$joinedCombination'")->where('product_id', '=', $item->product_id)->first();

                $item->price = $price->price;
                $item->stock = $price->stock;
                $item->sku = $price->sku;
                $item->combinationInfo = array();


                foreach ($attributes as $attribute) {
                    /** @var Attribute $attribute */
                    foreach ($attribute->values as $value) {
                        foreach ($item->combination as $combinationItem) {
                            if ($combinationItem == $value->id) {
                                $combinationInfoItem = new \stdClass();
                                $combinationInfoItem->id = $value->id;
                                $combinationInfoItem->name = $attribute->name;
                                $combinationInfoItem->name_sr = $attribute->name_sr;
                                $combinationInfoItem->value = $value->value;
                                $combinationInfoItem->value_sr = $value->value_sr;
                                $item->combinationInfo[] = $combinationInfoItem;
                                break;
                            }
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
                if(isset($item->email)) {
                    $cartTotal += Product::findOrFail($item->product_id)->price;
                }else{
                    $joinedCombination = '[' . join(', ', $item->combination) . ']';

                    $price = ProductPrice::query()->whereRaw("CAST(`product_prices`.`attributes` as char) = '$joinedCombination'")->where('product_id', '=', $item->product_id)->first();

                    $cartTotal += $price->price * $item->quantity;
                }
            }
        }

        return PriceUtils::formattedPrice($cartTotal);
    }


    public function makeOrder(Request $request)
    {
        $cart = $this->getCartObject();

        if (sizeof($cart) == 0) {
            return back();
        }

        $orderItems = array();
        $shippingPrice = 20.00;
        $totalPrice = 0;

        foreach ($cart as $key => $item) {
            if ($item->gift) {
                $item->email = $request->get("email-$key");
            } else {
                $item->quantity = (int)$request->get("quantity-$key");
                if ($item->quantity > $item->stock) {
                    return back()->with('warning', 'One of the items has ran out of stock.');
                }
            }
            $cart[$key] = $item;


            $attributes = array();


            if(!$item->gift) {
                foreach ($item->combinationInfo as $combinationInfoItem) {
                    $attribute = array();
                    $attribute['name'] = $combinationInfoItem->name;
                    $attribute['value'] = $combinationInfoItem->value;
                    $attributes[] = $attribute;
                }
            }else{
                $attribute = array();
                $attribute['name'] = 'email';
                $attribute['value'] = $item->email;
                $attributes[] = $attribute;
            }

            $orderItems[] = [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'sku' => $item->sku,
                'name' => $item->product_name,
                'name_sr' => $item->product_name_sr,
                'attributes' => json_encode($attributes)
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

        foreach ($orderItems as $key => $item) {
            $item['order_id'] = $order->id;
            $orderItems[$key] = $item;
        }

        OrderItem::insert($orderItems);

        $cookie = Cookie::forget('cart');

        foreach ($cart as $item) {
            if(!$item->gift) {
                $joinedCombination = '[' . join(', ', $item->combination) . ']';
                DB::table('product_prices')->whereRaw("CAST(`product_prices`.`attributes` as char) = '$joinedCombination'")
                    ->where('product_id', '=', $item->product_id)->decrement('stock', $item->quantity);
            }
        }


        \Auth::user()->notify(new OrderCreated($order));
        $admins = User::role('Administrator')->get();
        \Notification::send($admins, new OrderCreatedAdmin($order));

        return back()->with('message', 'Congratulations! An order has been made.')->withCookie($cookie);
    }
}