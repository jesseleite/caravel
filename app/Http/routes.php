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

Route::get('/', function () {
    return view('welcome');
});

// Adminer
Route::any('adminer', '\Miroc\LaravelAdminer\AdminerController@index');

// Caravel Admin
Route::group(['prefix' => config('caravel.route_prefix')], function () {
    Route::get('dashboard', '\ThisVessel\Caravel\Controllers\DashboardController@page');
    Route::resource('{resource}', '\ThisVessel\Caravel\Controllers\ResourceController');
});
