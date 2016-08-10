<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('contacts','Commercial\contactsController@index');
Route::get('customers','Commercial\contactsController@indexCustomers');
Route::get('suppliers','Commercial\contactsController@indexSuppliers');
Route::get('contacts/{id}','Commercial\contactsController@show');
Route::post('savecontacts', 'Commercial\contactsController@update');

Route::group(['middleware' => 'auth'], function () {
Route::get('kpi/{Key}/{StartDate}/{EndDate}', 'kpiController@Execute_KPI');
Route::get('getcomponents', 'kpiController@GetComponents');
Route::post('savedashboard', 'dashboardController@SaveDashboard');
Route::get('/', 'dashboardController@index');
});
