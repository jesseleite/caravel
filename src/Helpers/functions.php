<?php

if (! function_exists('caravel_route')) {
    /**
     * Get caravel route for a model action.
     *
     * @param  string  $action
     * @param  mixed  $model
     * @return string
     */
    function caravel_route($action, $model)
    {
        $resource = collect(config('caravel.resources'))->search(get_class($model));

        return route("caravel::{$resource}.$action", $model);
    }
}
