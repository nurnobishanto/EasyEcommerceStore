<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data =  array();
        return view('front.pages.home', $data);
    }
    public function category($slug){
        $category = Category::where('slug',$slug)->first();
        $products = $category->products;
        if ($category){
            return view('front.pages.category',compact(['products','category']));
        }else{
            abort(404);
        }
    }
    public function products(){
        $products = Product::where('status','active')->get();
        return view('front.pages.products',compact('products'));

    }
    public function product($slug){
        $product = Product::where('slug',$slug)->first();
        if ($product){
            return view('front.pages.single',compact('product'));
        }else{
            abort(404);
        }

    }
}
