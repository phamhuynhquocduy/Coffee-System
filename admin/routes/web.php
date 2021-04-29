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
// login
Route::get('/login', 'App\Http\Controllers\DashboardController@login')->name('login');
// post-login
Route::post('/post_login', 'App\Http\Controllers\DashboardController@post_login')->name('post-login');
// view admin
Route::get('/view-admin', 'App\Http\Controllers\DashboardController@view_admin');
// logout
Route::get('/logout', 'App\Http\Controllers\DashboardController@logout')->name('logout');
//product
Route::prefix('product')->group(function () {
    Route::get('/', 'App\Http\Controllers\ProductController@index')->name('product.index');
    Route::get('/create', 'App\Http\Controllers\ProductController@create')->name('product.create');
    Route::post('/save', 'App\Http\Controllers\ProductController@store')->name('product.store');
    Route::get('/{id}/edit', 'App\Http\Controllers\ProductController@edit')->name('product.edit');
    Route::get('/{id}/editjson', 'App\Http\Controllers\ProductController@editjson')->name('product.editjson');
    Route::post('/save/attribute', 'App\Http\Controllers\ProductController@save_attribute')->name('product.save-attribute');
    Route::post('/{id}/update', 'App\Http\Controllers\ProductController@update')->name('product.update');
    Route::get('/{id}', 'App\Http\Controllers\ProductController@destroy')->name('product.destroy');
});
//category json
Route::get('product/data/all/json', 'App\Http\Controllers\ProductController@conver_product_json')->name('product-json');
//category
Route::prefix('category')->group(function () {
    Route::get('/', 'App\Http\Controllers\CategoryController@index')->name('category.index');
    Route::get('/create', 'App\Http\Controllers\CategoryController@create')->name('category.create');
    Route::post('/save', 'App\Http\Controllers\CategoryController@store')->name('category.store');
    Route::get('/{id}/edit', 'App\Http\Controllers\CategoryController@edit')->name('category.edit');
    Route::post('/{id}/update', 'App\Http\Controllers\CategoryController@update')->name('category.update');
    Route::get('/{id}/delete', 'App\Http\Controllers\CategoryController@destroy')->name('category.destroy');
});
//category json
Route::get('category/data/all/json', 'App\Http\Controllers\CategoryController@conver_category_json')->name('category-json');

// json 1 cate to all product
Route::get('/data/json/{id}/one-cate-all-product','App\Http\Controllers\ProductController@one_cate_all_pro');

//customer
Route::prefix('customer')->group(function () {
    Route::get('/', 'App\Http\Controllers\CustomerController@index')->name('customer.index');
    Route::get('/create', 'App\Http\Controllers\CustomerController@create')->name('customer.create');
    Route::post('/save', 'App\Http\Controllers\CustomerController@store')->name('customer.store');
    Route::get('/{id}/show', 'App\Http\Controllers\CustomerController@show')->name('customer.show');
    Route::get('/{id}/edit', 'App\Http\Controllers\CustomerController@edit')->name('customer.edit');
    Route::post('/{id}/update', 'App\Http\Controllers\CustomerController@update')->name('customer.update');
    Route::get('/{id}/delete', 'App\Http\Controllers\CustomerController@destroy')->name('customer.destroy');
});
//customer json
Route::get('/customer/data/all/json', 'App\Http\Controllers\CustomerController@conver_customer_json')->name('customer-json');

// send mail
Route::get('/send-mail', 'App\Http\Controllers\MailController@get_send_mail')->name('get-send-mail');
// post send email
Route::post('/send-mail', 'App\Http\Controllers\MailController@post_send_mail')->name('post-send-mail');
//----------------------------------------------
//get send mail
Route::get('/customer/send-mail-api', 'App\Http\Controllers\Api\ResetPasswordApiController@get_send_email_api');
//post send mail
Route::post('/customer/send-mail-api', 'App\Http\Controllers\Api\ResetPasswordApiController@send_email_api')->name('post-send-mail-api');

// -------------------------------- test -----------------------------//
// Route::get('/test','App\Http\Controllers\ProductController@list' );

// -------------------------------- filter ---------------------------//
Route::get('product/filter/attribute/value', 'App\Http\Controllers\FilterAttributeController@all_attribute')->name('all-attribute');
Route::get('product/filter/attribute/value/result', 'App\Http\Controllers\FilterAttributeController@result_filter')->name('post-filter');
Route::get('product/filter/attribute/{id}/delete', 'App\Http\Controllers\FilterAttributeController@delete_attribute')->name('delete-attribute');
Route::get('product/filter/attribute/value/{id}/edit', 'App\Http\Controllers\FilterAttributeController@edit_attribute')->name('edit-attribute');
Route::post('product/filter/attribute/update', 'App\Http\Controllers\FilterAttributeController@update_attribute')->name('update-attribute');


