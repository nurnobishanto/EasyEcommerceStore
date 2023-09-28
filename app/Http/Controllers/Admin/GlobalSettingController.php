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
    public function page_setting(){
        return view('admin.settings.page');
    }
    public function site_setting_update(Request $request){

        setSetting('site_name',trim($request->site_name));
        setSetting('site_address',trim($request->site_address));
        setSetting('currency',trim($request->currency));
        setSetting('inquiry_number_one',trim($request->inquiry_number_one));
        setSetting('inquiry_number_two',trim($request->inquiry_number_two));
        setSetting('site_tagline',trim($request->site_tagline));
        setSetting('home_slider',trim($request->home_slider));
        setSetting('site_description',trim($request->site_description));
        setSetting('payment_method',trim($request->payment_method));

        setSetting('top_left_text',trim($request->top_left_text));
        setSetting('top_right_text',trim($request->top_right_text));
        setSetting('mobile_category_menu',trim($request->mobile_category_menu));
        setSetting('desktop_category_menu',trim($request->desktop_category_menu));
        setSetting('home_featured_category',trim($request->home_featured_category));
        setSetting('top_bar',trim($request->top_bar));
        setSetting('support_number',trim($request->support_number));
        setSetting('facebook',trim($request->facebook));
        setSetting('youtube',trim($request->youtube));
        setSetting('instagram',trim($request->instagram));
        setSetting('whatsapp',trim($request->whatsapp));

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
    public function page_setting_update(Request $request){
        setSetting('site_about',trim($request->site_about));
        setSetting('site_contact',trim($request->site_contact));
        setSetting('site_privacy',trim($request->site_privacy));
        setSetting('site_return_policy',trim($request->site_return_policy));
        setSetting('site_terms',trim($request->site_terms));

        toastr()->success(__('global.page_content').__('global.updated'));
        return redirect()->back();
    }
}
