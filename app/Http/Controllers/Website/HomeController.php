<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data =  array();
        return view('front.pages.home', $data);
    }
    public function category($slug){
        return $slug;
    }
    public function product($slug){
        return $slug;
    }
}
