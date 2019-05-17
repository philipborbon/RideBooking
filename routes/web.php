<?php

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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->action('HomeController@index');
    } else {
        return view('welcome');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('rideschedules/{id}/route', 'RideScheduleController@route');
Route::patch('rideschedules/{id}/route', 'RideScheduleController@routeUpdate');
Route::patch('rideschedules/{scheduleId}/route/{id}', [
	'uses' => 'RideScheduleController@markMain',
	'as' => 'mark-main'
]);
Route::delete('rideschedules/{scheduleId}/route/{id}', [
	'uses' => 'RideScheduleController@destroyRoute',
	'as' => 'delete-route'
]);
Route::resource('rideschedules', 'RideScheduleController');

Route::resource('routes', 'RouteController');
Route::resource('users','UserController');
Route::resource('vehicles','VehicleController');

