<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/dashboard', 'App\Http\Controllers\DashboardController@dashboard')->name('dashboard');
//product
Route::resource('product', App\Http\Controllers\ProductController::class);
//category json
Route::get('product/data/all/json', 'App\Http\Controllers\ProductController@conver_product_json')->name('product-json');
//category
Route::resource('category', App\Http\Controllers\CategoryController::class);
//category json
Route::get('category/data/all/json', 'App\Http\Controllers\CategoryController@conver_category_json')->name('category-json');