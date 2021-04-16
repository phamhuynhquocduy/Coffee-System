<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Customer;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// login customer
Route::post('/customer/login', 'App\Http\Controllers\Api\CustomerApiController@login');

Route::post('/customer/logout', 'App\Http\Controllers\Api\CustomerApiController@logout')->middleware(['auth:customer-api']);

Route::get('/customer/user', 'App\Http\Controllers\Api\CustomerApiController@user')->middleware(['auth:customer-api']);

Route::put('/customer/update', 'App\Http\Controllers\Api\ProfileCustomerController@update')->middleware(['auth:customer-api']);

Route::put('/customer/update-password', 'App\Http\Controllers\Api\ProfileCustomerController@update_password')->middleware(['auth:customer-api']);

Route::post('/customer/register', 'App\Http\Controllers\Api\CustomerApiController@register');

// reset password

Route::get('/customer/check_data_reset', 'App\Http\Controllers\Api\ResetPasswordApiController@check_reset_passwords');
