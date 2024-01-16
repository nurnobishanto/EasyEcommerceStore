<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $data =  array();
        return view('front.pages.home', $data);
    }
    public function categories(){
        $title = 'All Categories';
        $categories = Category::where('parent_id',null)->get();
        $products = Product::where('id',0)->paginate(5);
        return view('front.pages.categories',compact(['categories','title','products']));
    }
    public function category($slug){

        $category = Category::with('children.products', 'products')->where('slug',$slug)->first();
        if ($category){
            $parentCategoryProducts = $category->products;
            $childCategoryProducts = $category->children->flatMap(function ($childCategory) {
                return $childCategory->products;
            });
            $allProducts = $parentCategoryProducts->concat($childCategoryProducts);
            $productIds = $allProducts->pluck('id');
            $products = Product::whereIn('id', $productIds)->paginate(20);

            if ($category->children->count()>0){
                $title = $category->name.' Category';
                $categories = $category->children;
                return view('front.pages.categories',compact(['categories','title','products']));
            }
            return view('front.pages.category',compact(['products','category']));
        }else{
            abort(404);
        }
    }
    public function products(Request $request){
        $searchQuery = $request->input('query');
        $products = Product::where('status','active')->where('title', 'like', '%' . $searchQuery . '%')->paginate(getSetting('product_per_page')??20);
        return view('front.pages.products',compact('products'));
    }
    public function new_products(){
        $products = Product::where('status', 'active')->defaultOrder()
           // ->orderBy('created_at', 'desc')
            ->paginate(getSetting('product_per_page')??20);
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
            $orders = Order::where('id', $searchQuery)
                ->orWhere('order_id', $searchQuery)
                ->orWhere('phone', 'like', '%' . $searchQuery . '%')
                ->get();
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
        $data['title'] = getSetting('site_refund_title');
        $data['content'] = getSetting('site_refund');
        return view('front.pages.page',$data);
    }
    public function privacy(){
        $data = array();
        $data['title'] = getSetting('site_privacy_title');
        $data['content'] = getSetting('site_privacy');
        return view('front.pages.page',$data);
    }
    public function terms(){
        $data = array();
        $data['title'] = getSetting('site_terms_title');;
        $data['content'] = getSetting('site_terms');
        return view('front.pages.page',$data);
    }
    public function about(){
        $data = array();
        $data['title'] = getSetting('site_about_title');
        $data['content'] = getSetting('site_about');
        return view('front.pages.page',$data);
    }
    public function contact(){
        $data = array();
        $data['title'] = getSetting('site_contact_title');
        $data['content'] = getSetting('site_contact');
        return view('front.pages.page',$data);
    }
}
