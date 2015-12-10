<?php

namespace ThisVessel\Caravel\Helpers;

class Routing
{
    /**
     * Return explicit route names array without route prefix.
     *
     * @param  string $resource
     * @return array
     */
    public static function resourceNamesWithoutPrefix($resource)
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
