<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;



class CartController extends Controller
{

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
            return response()->json(['message' => 'Product added to cart']);
        }
        return response()->json(['message' => 'Product Stock out']);
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
}
