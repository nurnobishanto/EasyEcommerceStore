<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
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
        $products = $category->products()->paginate(20);
        if ($category){
            return view('front.pages.category',compact(['products','category']));
        }else{
            abort(404);
        }
    }
    public function products(Request $request){
        $searchQuery = $request->input('query');
        $products = Product::where('status','active')->where('title', 'like', '%' . $searchQuery . '%')->paginate(20);
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
    public function checkout(){
        return view('front.pages.checkout');
    }

    public function track_order(Request $request){
        $searchQuery = $request->input('query');
        $data = array();
        $data['msg'] = '';
        if ($searchQuery){
            $orders = Order::where('id',$searchQuery)->orWhere('order_id',$searchQuery)->orWhere('phone',$searchQuery)->get();
            $data['orders'] = $orders;
            if ($orders->count()>0){
                $data['msg'] = '<span class="text-success">'.$orders->count().' order found!</span>';
            }else{
                $data['msg'] = '<span class="text-danger">No order found!</span>';
            }

        }
        return view('front.pages.track',$data);
    }
    public function return_policy(){
        $data = array();
        $data['title'] = 'Return Policy';
        $data['content'] = getSetting('site_privacy');
        return view('front.pages.page',$data);
    }
    public function privacy(){
        $data = array();
        $data['title'] = 'Privacy Policy';
        $data['content'] = getSetting('site_return_policy');
        return view('front.pages.page',$data);
    }
    public function terms(){
        $data = array();
        $data['title'] = 'Terms & Conditions';
        $data['content'] = getSetting('site_terms');
        return view('front.pages.page',$data);
    }
    public function about(){
        $data = array();
        $data['title'] = 'About Us';
        $data['content'] = getSetting('site_about');
        return view('front.pages.page',$data);
    }
    public function contact(){
        $data = array();
        $data['title'] = 'Contact Us';
        $data['content'] = getSetting('site_contact');
        return view('front.pages.page',$data);
    }
}
