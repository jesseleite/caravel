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
        // If already set, return from property.
        if (isset($this->resource)) {
            var_dump('getting from property');
            return $this->resource;
        }

        // Otherwise get URI,
        $uri = request()->getRequestUri();

        // Remove route prefix,
        if (! empty(config('caravel.route_prefix'))) {
            $prefix = '/' . config('caravel.route_prefix');
            $uri = str_replace($prefix, null, $uri);
        }

        // Grab resource,
        $uri = ltrim($uri, '/');
        $parts = explode('/', $uri);
        $baseUri = $parts[0];

        // New up Resource object.
        $resource = new Resource($baseUri);

        // Set and return.
        return $this->resource = $resource;
    }
}
