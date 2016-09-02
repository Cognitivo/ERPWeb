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
Route::get('component/{Key}/{StartDate}/{EndDate}', 'ComponentController@Execute_KPI');
Route::get('component/getusercomponents', 'ComponentController@GetUserComponents');
Route::post('savedashboard', 'dashboardController@SaveDashboard');
Route::get('managecomponents','dashboardController@ManageDashboard');
Route::get('listcomponents','dashboardController@ListComponents');
Route::get('componentslist','ComponentController@ListComponents');
Route::get('showcreate','ComponentController@ShowCreate');
Route::post('createcomponent','ComponentController@CreateComponent');
Route::get('/', 'dashboardController@index');

Route::get('contacts.get',function()
{
  $query=Request::get('q');
  $contacts=$query?Contact::where('name','LIKE',"%$query%")->get():Contact::all();
  return View::make('contacts.index')->with($contacts);
});

Route::get('get_contacts',function(){
    $query = Request::get('query'); 
    $contacts= \App\Contact::where('parent_id_contact',Session::get('idcontact'))->where('name','LIKE',"%$query%")->get();    
     return response()->json($contacts);
    
});
Route::get('get_plan',function(){

    $query = Request::get('query');
    $plan= \App\Items::all();

         
     return response()->json($plan);    
});

Route::resource('contacts','Commercial\contactsController');
Route::resource('subscription','Commercial\contactsubscriptionController');
Route::resource('tag','Commercial\contactstagController');
Route::resource('relation','Commercial\relationController');
Route::resource('suppliers','Commercial\contactsController@indexSuppliers');
Route::resource('customers','Commercial\contactsController@indexCustomers');




});
