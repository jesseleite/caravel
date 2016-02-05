<?php

namespace ThisVessel\Caravel\Traits;

use ThisVessel\Caravel\Resource;

trait SetsResource
{
    /**
     * Pretty yucky way of helping ResourceController detect current resource.
     *
     * Note:
     * If I can find a way to get resource uri/key without having to parse
     * the request URI, then I can also remove 'prefix' from config,
     * and have user set the prefix explicitly on the route group.
     *
     * @return \ThisVessel\Caravel\Resource
     */
    public function setResource()
    {
        // Get current URI,
        $uri = request()->getRequestUri();

        // Remove request parameters,
        $uri = explode('?', $uri)[0];

        // Remove route prefix,
        if (! empty(config('caravel.prefix'))) {
            $prefix = '/' . config('caravel.prefix');
            $uri = str_replace($prefix, null, $uri);
        }

        // Grab resource name,
        $uri = ltrim($uri, '/');
        $parts = explode('/', $uri);
        $resource = $parts[0];

        // Only new up Resource object if $resource is a proper resource.
        // Important for avoiding errors on controller instantiation by router?
        $resources = config('caravel.resources');
        if (isset($resources[$resource])) {
            $this->resource = new Resource($resource);
        }
    }
}
