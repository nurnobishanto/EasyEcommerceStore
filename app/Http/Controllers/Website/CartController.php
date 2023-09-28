<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DeliveryZone;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    public function payment_method(Request $request){
        $id = $request->input('id');
        $pm =  PaymentMethod::find($id);
        if($pm){
            return response()->json([
                'message' => $pm->description,
            ]);
        }
        return response()->json([
            'message' => '',
        ]);

    }

    public function addToCart(Request $request)
    {

        $productId = $request->input('product_id');
        $product = Product::find($productId);
        if (!$product) {
            abort(404);
        }
        $quantity = session()->get("cart.$productId", 0);
        $quantity++;
        if($product->quantity >= $quantity){
            session()->put("cart.$productId", $quantity);
            return response()->json([
                'message' => 'Product added to cart',
                'status' => 'success',
            ]);
        }
        return response()->json([
            'message' => 'Product Stock out',
            'status' => 'error',
            ]);
    }

    public function minusFromCart(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);
        $cart = Session()->get('cart', []);
        if (!$product) {
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                Session()->put('cart', $cart);
            }
        }
        $quantity = session()->get("cart.$productId", 0);
        $quantity--;
        if(0  < $quantity){
            session()->put("cart.$productId", $quantity);
        }else{
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                Session()->put('cart', $cart);
            }
        }
        return response()->json(['message' => 'Product added to cart']);
    }
    public function removeFromCart(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = Session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session()->put('cart', $cart);
        }
        return response()->json(['message' => 'Product removed from cart']);
    }
    public function getCart()
    {
        $cart = session()->get('cart', []);

        $cartList = [];
        $totalItemCount = 0;
        $subtotal = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);

            if ($product) {
                $cartItem = [
                    'product_id' => $productId,
                    'name' => $product->title,
                    'image' => asset('uploads/'.$product->thumbnail),
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'total' => $product->price * $quantity,
                    'url' => route('product',['slug'=>$product->slug]),
                ];


                $cartList[] = $cartItem;

                $totalItemCount += $quantity;
                $subtotal += $cartItem['total'];
            }
        }

        return response()->json([
            'cartList' => $cartList,

            'totalItemCount' => $totalItemCount,
            'subtotal' => $subtotal,
        ]);
    }

    public function orderConfirm(Request $request){
        $request->validate([
            'name' => 'required',
            'phone' => ['required', 'regex:/^(01|\+8801|8801)[3456789]\d{8}$/'],
            'address' => 'required',
            'delivery_zone_id' => 'required',
        ]);
        if(getSetting('payment_method') == 'show'){
            $request->validate([
                'payment_method_id' => 'required',
                'trxid' => 'required',
                'paid_amount' => 'required',
                'sent_from' => 'required',

            ]);
        }


        $admin =  Admin::first();
        $delivery_zone = DeliveryZone::find($request->delivery_zone_id);
        $order = Order::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'order_note' => $request->order_note,
            'delivery_zone_id' => $request->delivery_zone_id,
            'status' => 'pending',
            'subtotal' => 0,
            'delivery_charge' => $delivery_zone->charge,
            'created_by' => $admin->id,
            'updated_by' => $admin->id,
        ]);
        if(getSetting('payment_method') == 'show'){
            $order->payment_method_id = $request->payment_method_id;
            $order->trxid = $request->trxid;
            $order->sent_from = $request->sent_from;
            $order->paid_amount = $request->paid_amount;
        }


        $cart = session()->get('cart', []);
        $subtotal = 0;
        $productsWithPivot = [];
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $product->quantity = $product->quantity -$quantity;
                $product->update();
                $sub_total = $quantity*$product->price;
                $productsWithPivot[] = [
                    'product_id' => $productId,
                    'order_id' => $order->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'sub_total' => $quantity*$product->price,
                ];
                $subtotal += $sub_total;
            }
        }
        DB::table('order_product')->insert($productsWithPivot);
        $order->subtotal = $subtotal;
        $order->update();
        Session()->put('cart',[]);
        toastr()->success($order->name.__('global.created_success'),__('global.order').__('global.created'));
        return redirect(route('success',['id'=>$order->id]));
    }
    public function success($id){
        $order = Order::where('id',$id)->first();
        if ($order){
            return view('front.pages.confirmation',compact('order'));
        }else{
            $order = Order::where('order_id',$id)->first();
            return view('front.pages.confirmation',compact('order'));
        }


    }
}
