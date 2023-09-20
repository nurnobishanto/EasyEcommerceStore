<?php


use App\Models\GlobalSetting;
use Illuminate\Support\Str;

if (!function_exists('myCustomFunction')) {

    function myCustomFunction($param)
    {
        // Your custom logic here
    }

}
if (!function_exists('homeSliders')) {

    function homeSliders(): \Illuminate\Database\Eloquent\Collection
    {
        return \App\Models\Slider::all();
    }

}
if (!function_exists('productHascategory')) {

    function productHascategory($product,$cat)
    {
        $response = false;
        foreach ($product->categories as $category){
            if ($category->id == $cat->id){
                $response = true;
            }
        }
        return $response;
    }

}
if (!function_exists('generateUniqueSlug')) {


    function generateUniqueSlug($text, $modelName,$id = null, $field = 'slug', $separator = '-')
    {
        // Normalize the text to create a basic slug
        $slug = Str::slug($text, $separator);

        // Check if a record with this slug already exists in the specified model
        $model = app($modelName);
        $originalSlug = $slug;
        $count = 2;

        if($id){
            while ($model::where($field, $slug)->where('id','!=',$id)->exists()) {
                $slug = $originalSlug . $separator . $count;
                $count++;
            }
        }else{
            while ($model::where($field, $slug)->exists()) {
                $slug = $originalSlug . $separator . $count;
                $count++;
            }
        }


        return $slug;
    }
}
if (!function_exists('setSetting')) {

    function setSetting($key, $value)
    {
         GlobalSetting::updateOrInsert(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
if (!function_exists('getSetting')) {
    function getSetting($key)
    {
        $setting = GlobalSetting::where('key', $key)->first();
        if ($setting) {
            return $setting->value;
        }
        return null;
    }
}
if (!function_exists('checkRolePermissions')) {

    function checkRolePermissions($role,$permissions){
        $status = true;
        foreach ($permissions as $permission){
            if(!$role->hasPermissionTo($permission)){
                $status = false;
            }
        }

        return $status;
    }
}
if (!function_exists('checkAdminRole')) {

    function checkAdminRole($admin,$role){
        $status = false;
       if($admin->hasAnyRole([$role])){
           $status = true;
       }

        return $status;
    }
}



