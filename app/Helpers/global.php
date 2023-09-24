<?php


use App\Models\GlobalSetting;
use App\Models\Product;
use Illuminate\Support\Str;

if (!function_exists('myCustomFunction')) {

    function myCustomFunction($param)
    {
        // Your custom logic here
    }

}
if (!function_exists('relatedProducts')) {

    function relatedProducts($productId)
    {
        $product = Product::find($productId);
        $categories = $product->categories;
        $relatedProducts = Product::whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('categories.id', $categories->pluck('id'));
        })
            ->where('id', '<>', $productId) // Exclude the current product
            ->take(5)
            ->get();
        return $relatedProducts;
    }

}
if (!function_exists('deliveryZones')) {

    function deliveryZones()
    {
        return \App\Models\DeliveryZone::where('status','active')->get();
    }

}
if (!function_exists('productGallery')) {

    function productGalleries($id)
    {
        $product = \App\Models\Product::find($id) ;
        return $product->gallery;
    }

}
if (!function_exists('calculateDiscountPercentage')) {

    function calculateDiscountPercentage($regularPrice, $sellingPrice) {
        if ($regularPrice <= 0) {
            return 0;
        }
        $discountPercentage = (($regularPrice - $sellingPrice) / $regularPrice) * 100;
        return round($discountPercentage); // Round to two decimal places.
    }

}
if (!function_exists('homeSliders')) {

    function homeSliders(): \Illuminate\Database\Eloquent\Collection
    {
        return \App\Models\Slider::where('status','active')->orderBy('order','DESC')->get();
    }

}
if (!function_exists('featuredCategories')) {

    function featuredCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return \App\Models\Category::where('status','active')->where('is_featured','yes')->get();
    }

}
if (!function_exists('featuredProducts')) {

    function featuredProducts(): \Illuminate\Database\Eloquent\Collection
    {
        return \App\Models\Product::where('status','active')->where('is_featured','yes')->orderBy('id','desc')->take(5)->get();
    }

}
if (!function_exists('popularProducts')) {

    function popularProducts()
    {
        return \App\Models\Product::where('status','active')->paginate(20);
    }

}
if (!function_exists('getMenus')) {

    function getMenus(): \Illuminate\Database\Eloquent\Collection
    {
        return \App\Models\Menu::where('status','active')->where('parent_id',null)->orderBy('order','ASC')->get();
    }

}
if (!function_exists('getCategories')) {

    function getCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return \App\Models\Category::where('status','active')->where('parent_id',null)->get();
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



