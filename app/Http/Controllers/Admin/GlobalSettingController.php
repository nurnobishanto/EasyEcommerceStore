<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    public function site_setting(){
        return view('admin.settings.site');
    }
    public function code_setting(){
        return view('admin.settings.code');
    }
    public function site_setting_update(Request $request){

        setSetting('site_name',trim($request->site_name));
        setSetting('currency',trim($request->currency));
        setSetting('inquiry_number_one',trim($request->inquiry_number_one));
        setSetting('inquiry_number_two',trim($request->inquiry_number_two));
        setSetting('site_tagline',trim($request->site_tagline));
        setSetting('home_slider',trim($request->home_slider));
        setSetting('site_description',trim($request->site_description));

        setSetting('top_left_text',trim($request->top_left_text));
        setSetting('top_right_text',trim($request->top_right_text));
        setSetting('mobile_category_menu',trim($request->mobile_category_menu));
        setSetting('desktop_category_menu',trim($request->desktop_category_menu));
        setSetting('home_featured_category',trim($request->home_featured_category));
        setSetting('top_bar',trim($request->top_bar));

        if($request->file('site_favicon')){
            $imagePath = $request->file('site_favicon')->store('site-photo');
            $old_image_path = "uploads/".getSetting('site_favicon');
            setSetting('site_favicon',$imagePath);
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }
        if($request->file('site_logo')){
            $imagePath = $request->file('site_logo')->store('site-photo');
            $old_image_path = "uploads/".getSetting('site_logo');
            setSetting('site_logo',$imagePath);
            if (file_exists($old_image_path)) {
                @unlink($old_image_path);
            }
        }

        toastr()->success(__('global.site_setting').__('global.updated'));
        return redirect()->back();
    }
    public function code_setting_update(Request $request){

        setSetting('header_code',trim($request->header_code));
       setSetting('body_code',trim($request->body_code));
        setSetting('footer_code',trim($request->footer_code));

        toastr()->success(__('global.header_footer_code').__('global.updated'));
        return redirect()->back();
    }
}
