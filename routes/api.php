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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
	Route::get('user/details', 'API\UserController@details');
	Route::get('schedule/list', 'API\RideScheduleController@activeSchedules');
	Route::get('wallet/detail', 'API\WalletController@detail');
	Route::post('wallet/topup', 'API\WalletController@topup');
	Route::get('wallet/topups', 'API\WalletController@topups');
	Route::post('booking/create', 'API\BookingController@create');
	Route::get('booking/passengerTypes', 'API\BookingController@passengerTypes');
	Route::get('booking/history', 'API\BookingController@history');
});
