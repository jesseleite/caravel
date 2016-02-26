<?php

namespace ThisVessel\Caravel;

use ThisVessel\Caravel\Traits\DbalFieldTypes;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Resource
{
    use DbalFieldTypes;

    public $name;
    public $className;
    public $newInstance;
    public $orderBy;
    public $fields;
    public $rules;
    public $query;
    public $softDeletes;
    public $formPartial;

    public function __construct($resource)
    {
        $this->setName($resource);
        $this->setClassName();
        $this->setNewInstance();
        $this->checkFillable();
        $this->setOrderBy();
        $this->setFields();
        $this->setRules();
        $this->setSoftDeletes();
        $this->setQueryBuilder();
        $this->setFormPartial();
    }

    protected function setName($resource)
    {
        $this->name = $resource;
    }

    protected function setClassName()
    {
        $this->className = config('caravel.resources')[$this->name];
    }

    protected function setNewInstance()
    {
        $this->newInstance = new $this->className;
    }

    protected function setOrderBy()
    {
        if (isset($this->newInstance->caravel['orderBy'])) {
            return $this->orderBy = $this->newInstance->caravel['orderBy'];
        }

        if (isset($this->newInstance->updated_at)) {
            return $this->orderBy = 'updated_at desc';
        }

        $this->orderBy = $this->newInstance->getKeyName() . ' desc';
    }

    protected function setFields()
    {
        $model = $this->newInstance;
        $types = $this->getDbalTypesFromModel($model);

        foreach ($model->getFillable() as $name) {
            $type = isset($types[$name]) ? $types[$name] : $this->getDbalTypeInstance('string');
            $options = isset($model->caravel[$name]) ? $model->caravel[$name] : null;
            $this->fields[$name] = new Field($name, $type, $options);
        }
    }

    public function setSoftDeletes()
    {
        if (method_exists($this->newInstance, 'getDeletedAtColumn')) {
            return $this->softDeletes = $this->newInstance->getDeletedAtColumn();
        }

        return false;
    }

    public function setFormPartial()
    {
        if (isset($this->newInstance->caravel['form'])) {
            return $this->formPartial = $this->newInstance->caravel['form'];
        }

        $this->formPartial = 'default';
    }

    public function checkFillable()
    {
        if (empty($this->newInstance->getFillable())) {
            return abort(403, 'Caravel requires fillable fields on model.');
        }
    }

    public function commonViewData()
    {
        return [
            'resource'    => $this->name,
            'newInstance' => $this->newInstance,
            'fields'      => $this->fields,
            'softDeletes' => $this->softDeletes,
            'formPartial' => $this->formPartial,
        ];
    }

    protected function setRules()
    {
        $this->rules = [];

        foreach ($this->fields as $field) {
            if (! empty($field->rules)) {
                $this->rules[$field->name] = $field->rules;
            }
        }
    }

    public function setQueryBuilder()
    {
        $model = $this->newInstance;
        $this->query = $model::query();

        // Remove all global scopes.
        if (method_exists($this->query, 'withoutGlobalScopes')) {
            $this->query->withoutGlobalScopes();
        }

        // Re-apply soft deletes scope.
        if (method_exists($this->query, 'withGlobalScope') && $this->softDeletes) {
            $this->query->withGlobalScope('SoftDeletes', new SoftDeletingScope);
        }

        $this->query->orderByRaw($this->orderBy);
    }

    public function searchable()
    {
        return method_exists($this->newInstance, 'scopeSearch') ? true : false;
    }

    public function trashed($trash)
    {
        if (! $this->softDeletes) {
            return $this->query;
        }

        $model = $this->newInstance;
        $query = $model::query();
        $orderByDeletedFirst = $this->softDeletes . ' desc, ' . $this->orderBy;

        if ($trash == 'only') {
            return $this->query = $query->onlyTrashed();
        }

        return $this->query = $query->withTrashed()->orderByRaw($orderByDeletedFirst);
    }

    /**
     * Pass dynamic method calls onto query builder.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->query, $method], $parameters);
    }
}
