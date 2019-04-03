<?php

use Illuminate\Http\Request;

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

Route::post('login', 'Auth\LoginController@login');


Route::group(['middleware' => ['cors']], function () {
    Route::get('/products', 'ProductController@index')->middleware('auth:api');
    Route::post('/checkout', 'CheckoutController@checkout')->middleware('auth:api');

});