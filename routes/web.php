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
//Cart Handle
Route::get('/cart/get', [\App\Http\Controllers\Website\CartController::class,'getCart'])->name('getCart');
Route::post('/cart/add', [\App\Http\Controllers\Website\CartController::class,'addToCart'])->name('addToCart');
Route::patch('/cart/update', [\App\Http\Controllers\Website\CartController::class,'updateCart'])->name('updateCart');
Route::delete('/cart/remove', [\App\Http\Controllers\Website\CartController::class,'removeFromCart'])->name('removeFromCart');
Route::delete('/cart/minus', [\App\Http\Controllers\Website\CartController::class,'minusFromCart'])->name('minusFromCart');


Route::get('/',[\App\Http\Controllers\Website\HomeController::class,'index'])->name('home');
Route::get('/category/{slug}',[\App\Http\Controllers\Website\HomeController::class,'category'])->name('category');
Route::get('/products',[\App\Http\Controllers\Website\HomeController::class,'products'])->name('products');
Route::get('/checkout',[\App\Http\Controllers\Website\HomeController::class,'checkout'])->name('checkout');
Route::get('/{slug}',[\App\Http\Controllers\Website\HomeController::class,'product'])->name('product');



require __DIR__.'/command.php';
