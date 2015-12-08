<?php

namespace ThisVessel\Caravel\Traits;

trait ResourceRouting
{
    public function routePrefix()
    {
        if (! empty(config('caravel.route_prefix'))) {
            return '/' . config('caravel.route_prefix');
        }

        return null;
    }

    public function routeIndex($resource)
    {
        return $this->routePrefix() . '/' . $resource;
    }
}
