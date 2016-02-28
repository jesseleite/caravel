<?php

namespace ThisVessel\Caravel;

use Route;

class Routes
{
    /**
     * Register all default routes.
     *
     * @return void
     */
    public static function default()
    {
        static::root();
        static::dashboard();
        static::resources();
    }

    /**
     * Register root route only.
     *
     * @return void
     */
    public static function root()
    {
        Route::get(null, [
            'as' => 'root',
            'uses' => '\ThisVessel\Caravel\Controllers\DashboardController@redirect',
        ]);
    }

    /**
     * Register dashboard route only.
     *
     * @return void
     */
    public static function dashboard()
    {
        Route::get('dashboard', [
            'as' => 'dashboard',
            'uses' => '\ThisVessel\Caravel\Controllers\DashboardController@index',
        ]);
    }

    /**
     * Register all resource related routes.
     *
     * @return void
     */
    public static function resources()
    {
        static::restfulResources();
        static::restoreResources();
    }

    /**
     * Register all conventional REST resource routes only.
     *
     * @return void
     */
    public static function restfulResources()
    {
        foreach (config('caravel.resources') as $resource => $model) {
            static::resource($resource, '\ThisVessel\Caravel\Controllers\ResourceController');
        }
    }

    /**
     * Register restore resource routes.
     *
     * @return void
     */
    public static function restoreResources()
    {
        foreach (config('caravel.resources') as $resource => $model) {
            Route::post("$resource/{id}/restore", [
                'as' => "$resource.restore",
                'uses' => '\ThisVessel\Caravel\Controllers\ResourceController@restore',
            ]);
        }
    }

    /**
     * Register custom REST resource routes.
     *
     * @param  string  $resource
     * @param  string  $controller
     * @return void
     */
    public static function resource($resource, $controller)
    {
        Route::resource($resource, $controller, [
            'names' => static::resourceNames($resource),
        ]);
    }

    /**
     * Fix resource names to ignore caravel prefix.
     *
     * @param  string  $resource
     * @return array
     */
    protected static function resourceNames($resource)
    {
        return [
            'index'   => $resource . '.index',
            'create'  => $resource . '.create',
            'store'   => $resource . '.store',
            'show'    => $resource . '.show',
            'edit'    => $resource . '.edit',
            'update'  => $resource . '.update',
            'destroy' => $resource . '.destroy',
        ];
    }
}
