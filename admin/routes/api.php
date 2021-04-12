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
// reset password
Route::get('/reset-password', 'App\Http\Controllers\ResetPasswordController@getSendMail')->name('get-send-mail');
Route::post('/reset-password', 'App\Http\Controllers\ResetPasswordController@sendMail')->name('send-mail');
Route::put('/reset-password/{token}', 'App\Http\Controllers\ResetPasswordController@reset')->name('reset-password');
