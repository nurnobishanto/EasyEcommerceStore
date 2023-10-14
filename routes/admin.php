<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DeliveryZoneController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::resource('/roles',RoleController::class)->middleware('permission:role_manage');
Route::resource('/permissions',PermissionController::class)->middleware('permission:permission_manage');

//Admin
Route::get('/admins/trashed',[AdminController::class,'trashed_list'])->middleware('permission:admin_manage')->name('admins.trashed');
Route::get('/admins/trashed/{admin}/restore',[AdminController::class,'restore'])->middleware('permission:admin_manage')->name('admins.restore');
Route::get('/admins/trashed/{admin}/delete',[AdminController::class,'force_delete'])->middleware('permission:admin_manage')->name('admins.force_delete');
Route::resource('/admins',AdminController::class)->middleware('permission:admin_manage');


//Brands
Route::get('/brands/trashed',[BrandController::class,'trashed_list'])->middleware('permission:brand_manage')->name('brands.trashed');
Route::get('/brands/trashed/{brand}/restore',[BrandController::class,'restore'])->middleware('permission:brand_manage')->name('brands.restore');
Route::get('/brands/trashed/{brand}/delete',[BrandController::class,'force_delete'])->middleware('permission:brand_manage')->name('brands.force_delete');
Route::resource('/brands',BrandController::class)->middleware('permission:brand_manage');

//Category
Route::get('/categories/trashed',[CategoryController::class,'trashed_list'])->middleware('permission:category_manage')->name('categories.trashed');
Route::get('/categories/trashed/{category}/restore',[CategoryController::class,'restore'])->middleware('permission:category_manage')->name('categories.restore');
Route::get('/categories/trashed/{category}/delete',[CategoryController::class,'force_delete'])->middleware('permission:category_manage')->name('categories.force_delete');
Route::resource('/categories',CategoryController::class)->middleware('permission:category_manage');

//Product
Route::get('/products/trashed',[ProductController::class,'trashed_list'])->middleware('permission:product_manage')->name('products.trashed');
Route::get('/products/trashed/{product}/restore',[ProductController::class,'restore'])->middleware('permission:product_manage')->name('products.restore');
Route::get('/products/trashed/{product}/delete',[ProductController::class,'force_delete'])->middleware('permission:product_manage')->name('products.force_delete');
Route::resource('/products',ProductController::class)->middleware('permission:product_manage');

//Order
Route::post('/orders/status/{order}/update',[OrderController::class,'order_status_update'])->middleware('permission:order_manage')->name('orders.status_update');
Route::get('/orders/{order}/print',[OrderController::class,'order_print'])->middleware('permission:order_manage')->name('orders.print');
Route::get('/orders/trashed',[OrderController::class,'trashed_list'])->middleware('permission:order_manage')->name('orders.trashed');
Route::get('/orders/trashed/{order}/restore',[OrderController::class,'restore'])->middleware('permission:order_manage')->name('orders.restore');
Route::get('/orders/trashed/{order}/delete',[OrderController::class,'force_delete'])->middleware('permission:order_manage')->name('orders.force_delete');
Route::resource('/orders',OrderController::class)->middleware('permission:order_manage');

//Slider
Route::get('/sliders/trashed',[SliderController::class,'trashed_list'])->middleware('permission:slider_manage')->name('sliders.trashed');
Route::get('/sliders/trashed/{slider}/restore',[SliderController::class,'restore'])->middleware('permission:slider_manage')->name('sliders.restore');
Route::get('/sliders/trashed/{slider}/delete',[SliderController::class,'force_delete'])->middleware('permission:slider_manage')->name('sliders.force_delete');
Route::resource('/sliders',SliderController::class)->middleware('permission:slider_manage');

//Menu
Route::get('/menus/trashed',[MenuController::class,'trashed_list'])->middleware('permission:menu_manage')->name('menus.trashed');
Route::get('/menus/trashed/{menu}/restore',[MenuController::class,'restore'])->middleware('permission:menu_manage')->name('menus.restore');
Route::get('/menus/trashed/{menu}/delete',[MenuController::class,'force_delete'])->middleware('permission:menu_manage')->name('menus.force_delete');
Route::resource('/menus',MenuController::class)->middleware('permission:menu_manage');

//Delivery Zone
Route::get('/delivery-zones/trashed',[DeliveryZoneController::class,'trashed_list'])->middleware('permission:delivery_zone_manage')->name('delivery-zones.trashed');
Route::get('/delivery-zones/trashed/{delivery_zone}/restore',[DeliveryZoneController::class,'restore'])->middleware('permission:delivery_zone_manage')->name('delivery-zones.restore');
Route::get('/delivery-zones/trashed/{delivery_zone}/delete',[DeliveryZoneController::class,'force_delete'])->middleware('permission:delivery_zone_manage')->name('delivery-zones.force_delete');
Route::resource('/delivery-zones',DeliveryZoneController::class)->middleware('permission:delivery_zone_manage');

//Payment methods
Route::get('/payment-methods/trashed',[PaymentMethodController::class,'trashed_list'])->middleware('permission:payment_method_manage')->name('payment-methods.trashed');
Route::get('/payment-methods/trashed/{payment_method}/restore',[PaymentMethodController::class,'restore'])->middleware('permission:payment_method_manage')->name('payment-methods.restore');
Route::get('/payment-methods/trashed/{payment_method}/delete',[PaymentMethodController::class,'force_delete'])->middleware('permission:payment_method_manage')->name('payment-methods.force_delete');
Route::resource('/payment-methods',PaymentMethodController::class)->middleware('permission:payment_method_manage');



//Site Setting
Route::get('site-setting',[\App\Http\Controllers\Admin\GlobalSettingController::class,'site_setting']);
Route::get('checkout-setting',[\App\Http\Controllers\Admin\GlobalSettingController::class,'checkout_setting']);
Route::get('code-setting',[\App\Http\Controllers\Admin\GlobalSettingController::class,'code_setting']);
Route::get('page/{slug}',[\App\Http\Controllers\Admin\GlobalSettingController::class,'page_setting']);
Route::post('site-setting',[\App\Http\Controllers\Admin\GlobalSettingController::class,'site_setting_update'])->name('site-setting');
Route::post('checkout-setting',[\App\Http\Controllers\Admin\GlobalSettingController::class,'checkout_setting_update'])->name('checkout-setting');
Route::post('code-setting',[\App\Http\Controllers\Admin\GlobalSettingController::class,'code_setting_update'])->name('code-setting');
Route::post('page-setting',[\App\Http\Controllers\Admin\GlobalSettingController::class,'page_setting_update'])->name('page-setting');

//Courier
Route::get('pathao',[\App\Http\Controllers\PathaoController::class,'pathao_list']);
Route::post('delivery-request/{id}',[\App\Http\Controllers\PathaoController::class,'delivery_request'])->name('delivery_request');

