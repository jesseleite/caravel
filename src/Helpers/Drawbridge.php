<?php

namespace ThisVessel\Caravel\Helpers;

use Gate;

class Drawbridge
{
    protected static function model($arguments)
    {
        return is_array($arguments) ? $arguments[0] : $arguments;
    }

    protected static function reviseAbility($ability, $model)
    {
        $resource = array_search(get_class($model), config('caravel.resources'));

        if (in_array($ability, ['update', 'delete'])) {
            $resource = str_singular($resource);
        }

        return "$ability-$resource";
    }

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

    protected static function hasAbility($ability, $arguments)
    {
        return Gate::has($ability);
    }

    public static function allows($ability, $arguments = [])
    {
        $model = static::model($arguments);
        $revisedAbility = static::reviseAbility($ability, $model);

        if (static::hasPolicy($ability, $arguments)) {
            return Gate::allows($ability, $arguments);
        } elseif (static::hasAbility($revisedAbility, $arguments)) {
            return Gate::allows($revisedAbility, $arguments);
        }

        return true;
    }

    public static function denies($ability, $arguments = [])
    {
        $model = static::model($arguments);
        $revisedAbility = static::reviseAbility($ability, $model);

        if (static::hasPolicy($ability, $arguments)) {
            return Gate::denies($ability, $arguments);
        } elseif (static::hasAbility($revisedAbility, $arguments)) {
            return Gate::denies($revisedAbility, $arguments);
        }

        return false;
    }

    public static function authorize($ability, $arguments = [])
    {
        if (static::denies($ability, $arguments)) {
            return abort(403, 'You shall not pass!');
        }

        return true;
    }
}
