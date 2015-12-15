<?php

namespace ThisVessel\Caravel\Helpers;

use Gate;

class Drawbridge
{
    /**
     * Check for policy or ability definition, otherwise skip authorization check and allow user.
     *
     * @param  string  $ability
     * @param  mixed   $arguments
     * @return boolean
     */
    public static function allows($ability, $arguments = [])
    {
        $model = static::model($arguments);
        $revisedAbility = static::explicitAbility($ability, $model);

        if (static::hasPolicy($ability, $arguments)) {
            return Gate::allows($ability, $arguments);
        } elseif (static::hasAbility($revisedAbility, $arguments)) {
            return Gate::allows($revisedAbility, $arguments);
        }

        return true;
    }

    /**
     * Check for policy or ability definition, otherwise skip authorization check and allow user.
     *
     * @param  string  $ability
     * @param  mixed   $arguments
     * @return boolean
     */
    public static function denies($ability, $arguments = [])
    {
        return ! static::allows($ability, $arguments);
    }

    /**
     * Check for policy or ability definition, otherwise skip authorization check and allow user.
     *
     * @param  string  $ability
     * @param  mixed   $arguments
     * @return mixed
     */
    public static function authorize($ability, $arguments = [])
    {
        return static::allows($ability, $arguments) ? true : abort(403, 'You shall not pass!');
    }

    /**
     * Grab model from arguments.
     *
     * @param  mixed  $arguments
     * @return \Illuminate\Database\Eloquent\Model;
     */
    protected static function model($arguments)
    {
        return is_array($arguments) ? $arguments[0] : $arguments;
    }

    /**
     * Revise ability to include explicit resource name.
     *
     * @param  string  $ability
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return string
     */
    protected static function explicitAbility($ability, $model)
    {
        $resource = array_search(get_class($model), config('caravel.resources'));

        if (in_array($ability, ['update', 'delete'])) {
            $resource = str_singular($resource);
        }

        return "$ability-$resource";
    }

    /**
     * Check if ability has been defined.
     *
     * @param  string  $ability
     * @param  mixed   $arguments
     * @return boolean
     */
    protected static function hasAbility($ability, $arguments)
    {
        return Gate::has($ability);
    }

    /**
     * Check if policy has been defined.
     *
     * @param  string  $policy
     * @param  mixed   $arguments
     * @return boolean
     */
    protected static function hasPolicy($policy, $arguments)
    {
        $model = static::model($arguments);

        try {
            $policyClass = Gate::getPolicyFor($model);
            $hasPolicy = method_exists($policyClass, $policy);
        } finally {
            return isset($hasPolicy) ? $hasPolicy : false;
        }
    }
}
