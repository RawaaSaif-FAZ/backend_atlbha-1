<?php

namespace App\Http\Controllers\api\storeDashboard;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\CartDetail;
use App\Models\Paymenttype;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use App\Models\coupons_users;
use App\Models\Importproduct;
use App\Models\coupons_products;
use App\Models\shippingtype_store;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PaymenttypeResource;
use App\Http\Resources\ShippingtypeTemplateResource;
use App\Http\Controllers\api\BaseController as BaseController;

class CheckoutController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function checkOut(Request $request)
    {

            $cart = Cart::where('user_id', auth()->user()->id)->where('store_id', null)->first();

            if ($cart == null) {
                $success['status'] = 200;

                return $this->sendResponse($success, ' سلة فارغة', 'cart is not exist');

            }
            $input = $request->all();
            $validator = Validator::make($input, [
                'city' => 'required|string|max:255',
                'street_address' => 'required|string',
                'district' => 'required|string',
                'postal_code' => 'nullable|string',
                'default_address' => 'required',
                'paymentype_id' => 'required|exists:paymenttypes,id',

                'cod' => 'nullable',
                'description' => 'nullable|string',

            ]);
            if ($validator->fails()) {
                return $this->sendError(null, $validator->errors());
            }

            // Create a new order
            $order = new Order();
            $order_number = Order::orderBy('id', 'desc')->first();

            if (is_null($order_number)) {
                $number = 0001;
            } else {

                $number = $order_number->order_number;
                $number = ((int) $number) + 1;
            }
            $order->order_number = str_pad($number, 4, '0', STR_PAD_LEFT);
            $order->user_id = $cart->user->id; // Assign the customer's ID
            $order->total_price = $cart->total; // Initialize the total price
            $order->quantity = $cart->count;
            $order->weight = $cart->weight;
            $order->totalCount = $cart->totalCount;
            $order->subtotal = $cart->subtotal;
            $order->tax = $cart->tax;
            $order->discount = $cart->discount_total;
            $order->order_status = "new";
            $order->payment_status = "pending";
            $order->store_id = null;
            $order->shippingtype_id = $request->shippingtype_id;
            $order->paymentype_id = $request->paymentype_id;
            $order->cod = $request->cod;
            $order->description = $request->description;

            // Save the order to the database
            $order->save();

            if ($cart->free_shipping == 1) {
                $shipping_price = $cart->shipping_price;
            } else {
                $shipping_price = 35;

            }

            if ($cart->free_shipping == 1)
             {
            $order->update([
                'shipping_price' => $shipping_price,
                'total_price' => $order->total_price,
            ]);
           }
           else{
            $order->update([
                'shipping_price' => $shipping_price,
                'total_price' => ($order->total_price-35)+$shipping_price,
            ]);

           }


            // Loop through the cart items and associate them with the order
            foreach ($cart->cartDetails as $cartItem) {
                $product = Product::where('is_deleted', 0)->where('id', $cartItem->product_id)->where('store_id', null)->first();
                if ($product != null) {
                    $product->update([
                        'stock' => $product->stock - $cartItem->qty,
                    ]);
                }
            }
            foreach ($cart->cartDetails as $cartItem) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id; // Associate the order with the order item
                $orderItem->product_id = $cartItem->product_id;
                $orderItem->quantity = $cartItem->qty;
                $orderItem->price = $cartItem->price;
                $orderItem->total_price = ($cartItem->price * $cartItem->qty);
                $orderItem->option_id = $cartItem->option_id;
                $orderItem->store_id = null;
                $orderItem->user_id = auth()->user()->id;
                $orderItem->save();
            }
            $subtotal = OrderItem::where('order_id', $order->id)->get()->reduce(function ($total, $item) {
                return $total + ($item->quantity * $item->price);
            });

            $orderAddress = OrderAddress::where('user_id', auth()->user()->id)->first();

            if ($orderAddress === null) {

                $orderaddress = OrderAddress::create([
                    'city' => $request->city,
                    'street_address' => $request->street_address,
                    'district' => $request->district,
                    'postal_code' => $request->postal_code,
                    'default_address' => $request->default_address,
                    'user_id' => auth()->user()->id,
                    'shippingtype_id' => null,

                ]);
                if ($orderaddress->default_address === '1') {

                    $addresses = OrderAddress::where('user_id', auth()->user()->id)->whereNot('id', $orderaddress->id)->get();
                    foreach ($addresses as $address) {
                        $address->update([
                            'default_address' => 0,
                        ]);
                    }
                }

                $order->order_addresses()->attach($orderaddress->id, ["type" => "shipping"]);
            } else {
                $orderAddress->update([
                    'city' => $request->city,
                    'street_address' => $request->street_address,
                    'district' => $request->district,
                    'postal_code' => $request->postal_code,
                    'default_address' => $request->default_address,
                    'shippingtype_id' =>null,
                ]);
                $order->order_addresses()->attach($orderAddress->id, ["type" => "shipping"]);
                if ($orderAddress->default_address === '1') {

                    $addresses = OrderAddress::where('user_id', auth()->user()->id)->whereNot('id', $orderAddress->id)->get();
                    foreach ($addresses as $address) {
                        $address->update([
                            'default_address' => 0,
                        ]);
                    }
                }

            }

            if ($order->paymentype_id == 4) {

                //الدفع عند الاستلام
                $order->update([
                    'total_price' => $order->total_price + 10,
                    'payment_status' => "pending",
                    'order_status' => "new",
                    'cod' => 1,
                ]);

                $cart->delete();
            } else {
                if ($order->paymentype_id == 1) {

                }
                $order->update([
                    'payment_status' => "pending",
                    'order_status' => "new",
                    'cod' => 0,
                ]);

                $cart->delete();
            }

            $success['order'] = new OrderResource($order);

            $success['status'] = 200;

            return $this->sendResponse($success, 'تم ارسال طلب الاستيرد
            بعد الموافقة تجدها في قسم المنتجات وخلال ثلاث ايام توصلك المنتجات', 'order send successfully');


    }
    public function paymentMethods()
    {

        $success['payment_types'] = PaymenttypeResource::collection(Paymenttype::where('is_deleted',0)->orderByDesc('created_at')->whereNot('id',4)->get());
        $success['status'] = 200;

        return $this->sendResponse($success, 'تم ارجاع طرق الدفع بنجاح', 'Payment Types return successfully');
    }



    public function applyCoupon(Request $request, $cart_id)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'code' => 'required',

        ]);
        if ($validator->fails()) {
            return $this->sendError(null, $validator->errors());
        }
        $coupon = Coupon::where('code', $request->code)->where('is_deleted', 0)->first();

        if ($coupon != null && $coupon->status == 'active') {

            $cart = Cart::where('id', $cart_id)->where('store_id', null)->first();
                $coupon->users()->attach(auth()->user()->id);
                $user = User::where('id', auth()->user()->id)->first();
                 $useCouponUser = coupons_users::where('user_id', auth()->user()->id)->where('coupon_id', $coupon->id)->get();
                $useCouponAll = coupons_users::where('coupon_id', $coupon->id)->get();
                if ($coupon->user_redemptions >= count($useCouponUser) && $coupon->total_redemptions >= count($useCouponAll)) {
                        if ($coupon->discount_type == 'fixed') {
                            $cartAfterdiscount = $cart->total - $coupon->discount;
                            $cart->update([
                                'total' => $cartAfterdiscount,
                                'discount_type' => 'fixed',
                                'discount_value' => $coupon->discount,
                                'discount_total' => ($cart->discount_total !== null ? $cart->discount_total : 0) + $coupon->discount,

                            ]);

                        } else {
                            $couponDiscountPercent = $coupon->discount / 100;
                            $discountAmount = $cart->total * $couponDiscountPercent;
                            $cartAfterdiscount = $cart->total - $discountAmount;
                            $cartCopun = $cart->total - $cartAfterdiscount;
                            $cart->update([
                                'total' => $cartAfterdiscount,
                                'discount_type' => 'percent',
                                'discount_value' => $coupon->discount . '%',
                                'discount_total' => ($cart->discount_total !== null ? $cart->discount_total : 0) + round($cartCopun, 2),
                            ]);

                        }

                    }
                    else {
                        $success['status'] = 200;

                        return $this->sendResponse($success, 'الكوبون غير صالح', 'The coupon is invalid');

                    }


            $success['cart'] = new CartResource($cart);
            $success['status'] = 200;

            return $this->sendResponse($success, 'تم تفعيل الكوبون بنجاح', 'coupon updated successfully');

        } else {
            $success['status'] = 200;

            return $this->sendResponse($success, 'الكوبون غير صالح', 'The coupon is invalid');

        }

    }


}
