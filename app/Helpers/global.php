<?php


use App\Models\Category;
use App\Models\GlobalSetting;
use App\Models\IpBlock;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

if (!function_exists('myCustomFunction')) {

    function myCustomFunction($param)
    {
        // Your custom logic here
    }

}
if (!function_exists('getSteadfastBalance')) {

    function getSteadfastBalance()
    {
        $apiUrl = 'https://portal.steadfast.com.bd/api/v1/get_balance';
        $apiKey = getSetting('steadfast_api_key');
        $secretKey = getSetting('steadfast_secret_key');

        $response = Http::withHeaders([
            'Api-Key' => $apiKey,
            'Secret-Key' => $secretKey,
            'Content-Type' => 'application/json',
        ])->get($apiUrl);

        // Handle the response as needed
        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['status']) && $responseData['status'] == 200) {
                setSetting('steadfast_status',true);
                return $responseData['current_balance'];
            }
        }
        setSetting('steadfast_status',false);
        return 'Failed to check the balance';
    }


}
if (!function_exists('isIpBlock')) {

    function isIpBlock($ip)
    {
        $ip = IpBlock::where('ip_address',$ip)->first();
        if ($ip && $ip->status == 'active'){
            return true;
        }
        return false;
    }

}


if (!function_exists('pathaoStoreList')) {
    function pathaoStoreList() {
        issuePathaoToken();
        $url = getSetting('pathao_base_url'). '/aladdin/api/v1/stores';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . getSetting('pathao_access_token'),
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return [];
        }
        curl_close($ch);

        if ($response === false || $response === 'Unauthorized.') {
            toastr()->warning('Please Fix the Pathao Information');
            return [];
        }
        $responseData = json_decode($response, true);
        if ($responseData['code'] === 200) {
            return $responseData['data']['data'];
        }
    }
}
if (!function_exists('apiRequest')) {
    function apiRequest($url, $data) {
        $dataString = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($dataString)
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode !== 200) {
            setSetting('pathao_status', 'off');
            return false;
        }
        $responseData = json_decode($response, 'on');
        if ($responseData) {
            setSetting('pathao_status', 'on');
            if (isset($responseData['access_token'])) {
                setSetting('pathao_access_token', $responseData['access_token']);
            }
            if (isset($responseData['refresh_token'])) {
                setSetting('pathao_refresh_token', $responseData['refresh_token']);
            }
            return true;
        } else {
            setSetting('pathao_status', 'off');
            return false;
        }
    }
}
if (!function_exists('issuePathaoToken')) {
    function issuePathaoToken() {
        $accessToken = getSetting('pathao_access_token');
        if ($accessToken != 'null') {
           return refreshPathaoToken();
        }
        $url = getSetting('pathao_base_url') . '/aladdin/api/v1/issue-token';
        $data = [
            'client_id' => getSetting('pathao_client_id'),
            'client_secret' => getSetting('pathao_client_secret'),
            'username' => getSetting('pathao_client_email'),
            'password' => getSetting('pathao_client_password'),
            'grant_type' => 'password',
        ];
        return apiRequest($url, $data);
    }
}
if (!function_exists('refreshPathaoToken')) {
    function refreshPathaoToken() {
        $url = getSetting('pathao_base_url') . '/aladdin/api/v1/issue-token';
        $data = [
            'client_id' => getSetting('pathao_client_id'),
            'client_secret' => getSetting('pathao_client_secret'),
            'refresh_token' => getSetting('pathao_refresh_token'),
            'grant_type' => 'refresh_token',
        ];
        return apiRequest($url, $data);
    }
}

if (!function_exists('countCategoryProducts')) {

    function countCategoryProducts($slug)
    {
        $category = Category::with('children.products', 'products')->where('slug',$slug)->first();
        $parentCategoryProducts = $category->products;
        $childCategoryProducts = $category->children->flatMap(function ($childCategory) {
            return $childCategory->products;
        });
        $allProducts = $parentCategoryProducts->concat($childCategoryProducts);
        $productIds = $allProducts->pluck('id');
        return Product::whereIn('id', $productIds)->count();

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
if (!function_exists('paymentMethods')) {

    function paymentMethods()
    {
        return \App\Models\PaymentMethod::where('status','active')->get();
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
if (!function_exists('coorHelper')) {
        function coorHelper(){
            $apiUrl = 'https://subscription.soft-itbd.com/check-subscription';
            $data = [
                'domain' => $_SERVER['HTTP_HOST'] ?? '',
            ];
            $ch = curl_init($apiUrl);
            // Set cURL options for POST request
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response instead of outputting it
            curl_setopt($ch, CURLOPT_POST, true); // Set the request method to POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Set POST data
            // Add headers or authentication if needed

            $response = curl_exec($ch); // Execute the cURL request

            // Check for cURL errors
            if (curl_errno($ch)) {
                echo 'cURL error: ' . curl_error($ch);
            } else {
                $responseData = json_decode($response, true); // Decode the JSON response
                curl_close($ch); // Close cURL session

                // Assuming you have a response array named $responseData
                if (isset($responseData['status']) && $responseData['status']) {
                    setSetting('subscription_expire_date',$responseData['product']['end_date']);
                    setSetting('subscription_remaining',$responseData['remaining']);
                    setSetting('subscription_last_check',date('Y-m-d',time()));
                }
                else if (isset($responseData['status']) && !$responseData['status'] && isset($responseData['product'])) {
                    header('Location: https://subscription.soft-itbd.com/expired/'.$responseData['product']['pid']); // Replace with your desired redirect URL
                    exit; // Terminate script execution
                }
                else {
                    // Subscription is not active, redirect to another website URL
                    header('Location: https://subscription.soft-itbd.com/expired/0'); // Replace with your desired redirect URL
                    exit; // Terminate script execution
                }
            }
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

        if ($id) {
            while ($model::withTrashed()
                ->where($field, $slug)
                ->where('id', '!=', $id)
                ->exists()) {
                $slug = $originalSlug . $separator . $count;
                $count++;
            }
        } else {
            while ($model::withTrashed()
                ->where($field, $slug)
                ->exists()) {
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



