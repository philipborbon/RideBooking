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

Route::get('reports', 'ReportController@index');
Route::get('reports/PassengerDailyPayment', 'ReportController@passengerDailyPayment');
Route::get('reports/PassengerMontlyPayment', 'ReportController@passengerMonthlyPayment');
Route::get('reports/PassengerYearlyPayment', 'ReportController@passengerYearlyPayment');

Route::get('reports/DriverDailyCollection', 'ReportController@driverDailyCollection');
Route::get('reports/DriverMontlyCollection', 'ReportController@driverMonthlyCollection');
Route::get('reports/DriverYearlyCollection', 'ReportController@driverYearlyCollection');

Route::get('reports/OperatorDailyBoundary', 'ReportController@operatorDailyBoundary');
Route::get('reports/OperatorMonthlyBoundary', 'ReportController@operatorMonthlyBoundary');
Route::get('reports/OperatorYearlyBoundary', 'ReportController@operatorYearlyBoundary');

Route::get('reports/VehicleDailylyIncome', 'ReportController@vehicleDailyIncome');
Route::get('reports/VehicleMonthlyIncome', 'ReportController@vehicleMonthlyIncome');
Route::get('reports/VehicleYearlyIncome', 'ReportController@vehicleYearlyIncome');

Route::resource('collections', 'VehicleCollectionController');
Route::patch('collections/{id}/approve', 'VehicleCollectionController@approve');

Route::resource('bookings', 'BookingController');
Route::patch('bookings/{id}/approve', 'BookingController@approve');
Route::patch('bookings/{id}/cancel', 'BookingController@cancel');

Route::resource('passengertypes', 'PassengerTypeController');
Route::resource('transactions', 'WalletTransactionController');

Route::resource('topups', 'TopupController');
Route::patch('topups/{id}/approve', 'TopupController@approve');

Route::resource('redeems', 'RedeemController');
Route::patch('redeems/{id}/approve', 'RedeemController@approve');

Route::resource('wallets', 'WalletController');

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

