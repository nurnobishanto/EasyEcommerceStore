<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryZone;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    public function index(){
        App::setLocale(session('locale'));
        $data = array();
        $data['brands'] = Brand::all();
        $data['categories'] = Category::all();
        $data['products'] = Product::all();
        $data['orders'] = Order::all();
        $data['recent_orders'] = Order::orderBy('created_at', 'desc')->take(10)->get();
        $data['zones'] = DeliveryZone::all();
        return view('admin.dashboard',$data);
    }
}
