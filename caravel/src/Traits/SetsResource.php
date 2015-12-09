<?php

namespace ThisVessel\Caravel\Traits;

use ThisVessel\Caravel\Resource;

trait SetsResource
{
    /**
     * Pretty yucky way of helping ResourceController detect current resource.
     *
     * @return \ThisVessel\Caravel\Resource
     */
    public function setResource()
    {
        // Get current URI,
        $uri = request()->getRequestUri();

        // Remove route prefix,
        if (! empty(config('caravel.route_prefix'))) {
            $prefix = '/' . config('caravel.route_prefix');
            $uri = str_replace($prefix, null, $uri);
        }

        // Grab resource name,
        $uri = ltrim($uri, '/');
        $parts = explode('/', $uri);
        $baseUri = $parts[0];

        $this->resource = new Resource($baseUri);
    }
}
