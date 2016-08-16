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

//Security
Route::group(['middleware' => 'auth'], function ()
{
Route::get('kpi/{Key}/{StartDate}/{EndDate}', 'kpiController@Execute_KPI');
Route::get('kpi/getusercomponents', 'kpiController@GetUserComponents');
Route::post('savedashboard', 'dashboardController@SaveDashboard');
Route::get('managecomponents','dashboardController@ManageDashboard');
Route::get('listcomponents','dashboardController@ListComponents');
Route::get('listcomponents','dashboardController@ListComponents');
Route::get('/', 'dashboardController@index');

Route::resource('contacts','Commercial\contactsController');
Route::resource('subscription','Commercial\contactsubscriptionController');
Route::resource('relation','Commercial\relationController');
Route::resource('suppliers','Commercial\contactsController@indexSuppliers');
Route::resource('customers','Commercial\contactsController@indexCustomers');




});
