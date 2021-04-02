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
Route::prefix('product')->group(function () {
    Route::get('/', 'App\Http\Controllers\ProductController@index')->name('product.index');
    Route::get('/create', 'App\Http\Controllers\ProductController@create')->name('product.create');
    Route::post('/save', 'App\Http\Controllers\ProductController@store')->name('product.store');
    Route::get('/{id}/edit', 'App\Http\Controllers\ProductController@edit')->name('product.edit');
    Route::post('/{id}/update', 'App\Http\Controllers\ProductController@update')->name('product.update');
    Route::get('/{id}', 'App\Http\Controllers\ProductController@destroy')->name('product.destroy');
});
//category json
Route::get('product/data/all/json', 'App\Http\Controllers\ProductController@conver_product_json')->name('product-json');
//category
Route::prefix('category')->group(function () {
    Route::get('', 'App\Http\Controllers\CategoryController@index')->name('category.index');
    Route::get('/create', 'App\Http\Controllers\CategoryController@create')->name('category.create');
    Route::post('/save', 'App\Http\Controllers\CategoryController@store')->name('category.store');
    Route::get('/{id}/edit', 'App\Http\Controllers\CategoryController@edit')->name('category.edit');
    Route::post('/{id}/update', 'App\Http\Controllers\CategoryController@update')->name('category.update');
    Route::get('/{id}/delete', 'App\Http\Controllers\CategoryController@destroy')->name('category.destroy');
});
//category json
Route::get('category/data/all/json', 'App\Http\Controllers\CategoryController@conver_category_json')->name('category-json');