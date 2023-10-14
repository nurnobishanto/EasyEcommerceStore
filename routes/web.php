<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Pathao CallBack
Route::post('pathao-status',[\App\Http\Controllers\PathaoController::class,'pathao_status']);
//Cart Handle
Route::post('/payment-method', [\App\Http\Controllers\Website\CartController::class,'payment_method'])->name('getPaymentMethod');
Route::get('/cart/get', [\App\Http\Controllers\Website\CartController::class,'getCart'])->name('getCart');
Route::post('/cart/add', [\App\Http\Controllers\Website\CartController::class,'addToCart'])->name('addToCart');
Route::patch('/cart/update', [\App\Http\Controllers\Website\CartController::class,'updateCart'])->name('updateCart');
Route::delete('/cart/remove', [\App\Http\Controllers\Website\CartController::class,'removeFromCart'])->name('removeFromCart');
Route::delete('/cart/minus', [\App\Http\Controllers\Website\CartController::class,'minusFromCart'])->name('minusFromCart');

Route::post('/cart/order-confirm', [\App\Http\Controllers\Website\CartController::class,'orderConfirm'])->name('orderConfirm');
Route::get('/success/{id}', [\App\Http\Controllers\Website\CartController::class,'success'])->name('success');

//Pathao API
Route::get('pathao/city-lists',[\App\Http\Controllers\PathaoController::class,'city_lists'])->name('pathao_city_lists');
Route::get('pathao/zone-lists/{id}',[\App\Http\Controllers\PathaoController::class,'zone_lists'])->name('pathao_zone_lists');
Route::get('pathao/area-lists/{id}',[\App\Http\Controllers\PathaoController::class,'area_lists'])->name('pathao_area_lists');
Route::post('pathao/price',[\App\Http\Controllers\PathaoController::class,'price'])->name('pathao_price');

Route::get('/',[\App\Http\Controllers\Website\HomeController::class,'index'])->name('home');
Route::get('/categories',[\App\Http\Controllers\Website\HomeController::class,'categories'])->name('categories');
Route::get('/category/{slug}',[\App\Http\Controllers\Website\HomeController::class,'category'])->name('category');
Route::get('/products',[\App\Http\Controllers\Website\HomeController::class,'products'])->name('products');
Route::get('/new-products',[\App\Http\Controllers\Website\HomeController::class,'new_products'])->name('new_products');
Route::get('/checkout',[\App\Http\Controllers\Website\HomeController::class,'checkout'])->name('checkout');
Route::get('/track-order',[\App\Http\Controllers\Website\HomeController::class,'track_order'])->name('track_order');
Route::get('/about',[\App\Http\Controllers\Website\HomeController::class,'about'])->name('about');
Route::get('/contact',[\App\Http\Controllers\Website\HomeController::class,'contact'])->name('contact');
Route::get('/terms',[\App\Http\Controllers\Website\HomeController::class,'terms'])->name('terms');
Route::get('/privacy',[\App\Http\Controllers\Website\HomeController::class,'privacy'])->name('privacy');
Route::get('/return-policy',[\App\Http\Controllers\Website\HomeController::class,'return_policy'])->name('return_policy');
Route::get('/{slug}',[\App\Http\Controllers\Website\HomeController::class,'product'])->name('product');



require __DIR__.'/command.php';
