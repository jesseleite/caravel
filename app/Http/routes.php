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


Route::group(['prefix' => config('caravel.route_prefix')], function () {
    foreach (config('caravel.resources') as $resource => $model) {
        Route::get($resource, function () use ($resource, $model){
            $data['resource'] = $resource;
            $data['model'] = $model;
            $data['items'] = $model::all();
            return view('caravel::list', $data);
        });
    }
});

// Adminer
Route::any('adminer', '\Miroc\LaravelAdminer\AdminerController@index');
