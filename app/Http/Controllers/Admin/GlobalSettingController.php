<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    public function site_setting(){
        return view('admin.settings.site');
    }
}
