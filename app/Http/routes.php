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

Route::get('/', 'dashboardcontroller@index');
Route::get('facturaspordia', 'kpicontroller@facturaspordia');
Route::get('top10productperbranch','kpicontroller@top10products');
Route::get('porcentajetag','kpicontroller@porcentajetag');
Route::get('totalsales','kpicontroller@totalsales');
Route::get('getconfig','kpicontroller@getconfig');
Route::get('salesperfootfall','kpicontroller@salesperfootfall');
Route::get('averagequantityperinv','kpicontroller@averagequantityperinv');
Route::get('averagesalesperinv','kpicontroller@averagesalesperinv');
Route::get('/login','dashboardcontroller@login');
