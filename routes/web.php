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
Route::get('/',[\App\Http\Controllers\Website\HomeController::class,'index'])->name('home');
Route::get('/category/{slug}',[\App\Http\Controllers\Website\HomeController::class,'category'])->name('category');
Route::get('/products',[\App\Http\Controllers\Website\HomeController::class,'products'])->name('products');
Route::get('/{slug}',[\App\Http\Controllers\Website\HomeController::class,'product'])->name('product');



require __DIR__.'/command.php';
