<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    public function site_setting(){
        return view('admin.settings.site');
    }
    public function checkout_setting(){
        return view('admin.settings.checkout');
    }
    public function code_setting(){
        return view('admin.settings.code');
    }

    public function site_setting_update(Request $request){

        setSetting('site_name',trim($request->site_name));
        setSetting('site_address',trim($request->site_address));

        setSetting('site_tagline',trim($request->site_tagline));
        setSetting('home_slider',trim($request->home_slider));
        setSetting('home_slider_text',trim($request->home_slider_text));
        setSetting('site_description',trim($request->site_description));


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
    public function page_setting($slug){
        $data = array();
        $data['slug'] = $slug;
        if ($slug == 'about'){
            $data['title'] = 'About Us';
            $data['heading'] = 'site_about_title';
            $data['content'] = 'site_about';
        }
        else if ($slug == 'contact'){
            $data['title'] = 'Contact Us';
            $data['heading'] = 'site_contact_title';
            $data['content'] = 'site_contact';
        }
        else if ($slug == 'terms'){
            $data['title'] = 'Terms and Conditions';
            $data['heading'] = 'site_terms_title';
            $data['content'] = 'site_terms';
        }
        else if ($slug == 'privacy'){
            $data['title'] = 'Privacy Policy';
            $data['heading'] = 'site_privacy_title';
            $data['content'] = 'site_privacy';
        }
        else if ($slug == 'refund'){
            $data['title'] = 'Refund Policy';
            $data['heading'] = 'site_refund_title';
            $data['content'] = 'site_refund';
        }
        return view('admin.settings.page',$data);
    }
    public function page_setting_update(Request $request){
        if ($request->slug === 'about'){
            setSetting('site_about_title',trim($request->site_about_title));
            setSetting('site_about',trim($request->site_about));
        }
        else if ($request->slug === 'contact'){
            setSetting('site_contact_title',trim($request->site_contact_title));
            setSetting('site_contact',trim($request->site_contact));
        }
        else if ($request->slug === 'terms'){
            setSetting('site_terms_title',trim($request->site_terms_title));
            setSetting('site_terms',trim($request->site_terms));
        }
        else if ($request->slug === 'privacy'){
            setSetting('site_privacy_title',trim($request->site_privacy_title));
            setSetting('site_privacy',trim($request->site_privacy));
        }
        else if ($request->slug === 'refund'){
            setSetting('site_refund_title',trim($request->site_refund_title));
            setSetting('site_refund',trim($request->site_refund));
        }
        toastr()->success(__('global.page_content').__('global.updated'));
        return redirect()->back();
    }
    public function checkout_setting_update(Request $request){
        setSetting('currency',trim($request->currency));
        setSetting('checkout_description',trim($request->checkout_description));
        setSetting('payment_method',trim($request->payment_method));
        setSetting('dc_required',trim($request->dc_required));
        setSetting('payment_discount',trim($request->payment_discount??0));
        setSetting('payment_max_discount',trim($request->payment_max_discount??0));
        setSetting('inquiry_number_one',trim($request->inquiry_number_one));
        setSetting('inquiry_number_two',trim($request->inquiry_number_two));
        toastr()->success(__('global.checkout_setting').__('global.updated'));
        return redirect()->back();
    }


}
