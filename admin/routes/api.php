<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth:customer-api'])->group(function () {
    Route::post('/logout', 'App\Http\Controllers\Api\CustomerApiController@logout');
});
Route::post('/customer/register', 'App\Http\Controllers\Api\CustomerApiController@register'); 
