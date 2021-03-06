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
Route::post('/signup', 'AuthController@signup');
Route::post('/verify-otp', 'AuthController@verifyOtp');
Route::post('/first-time-password', 'AuthController@firstTimePassword');
Route::post('/login-by-password', 'AuthController@loginByPhoneNumberAndPassword');
Route::post('/updateUser', 'UserController@userEditAPI');
Route::post('/create/circle', 'CircleController@create');
Route::get('/circle/{id}', 'CircleController@circleDetail');
Route::get('/circleList/{userid}', 'CircleController@index');
