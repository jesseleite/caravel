<?php

namespace ThisVessel\Caravel;

use ThisVessel\Caravel\Traits\DbalFieldTypes;

class Resource
{
    use DbalFieldTypes;

    public $name;
    public $className;
    public $newInstance;
    public $orderBy;
    public $fields;
    public $rules = [];
    public $query;
    public $softDeletes = false;

    public function __construct($resource)
    {
        $this->setName($resource);
        $this->setClassName();
        $this->setNewInstance();
        $this->checkFillable();
        $this->setOrderBy();
        $this->setFields();
        $this->setRules();
        $this->setQueryBuilder();
        $this->setSoftDeletes();
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
        $model = $this->newInstance;

        if (isset($model->caravel['orderBy'])) {
            $this->orderBy = $model->caravel['orderBy'];
        } elseif (isset($model->updated_at)) {
            $this->orderBy = 'updated_at desc';
        } else {
            $this->orderBy = $model->getKeyName() . ' desc';
        }
    }

    protected function setFields()
    {
        $model = $this->newInstance;
        $types = $this->getDbalTypesFromModel($model);

        foreach ($model->getFillable() as $name) {
            $type = isset($types[$name]) ? $types[$name] : $this->getDbalTypeInstance('string');
            $options = isset($model->caravel[$name]) ? $model->caravel[$name] : null;
            $this->fields[] = new Field($name, $type, $options);
        }
    }

    public function setSoftDeletes()
    {
        if (method_exists($this->newInstance, 'getDeletedAtColumn')) {
            $this->softDeletes = $this->newInstance->getDeletedAtColumn();
        }
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
            'resource' => $this->name,
            'newInstance' => $this->newInstance,
            'fields'   => $this->fields,
            'softDeletes' => $this->softDeletes,
        ];
    }

    protected function setRules()
    {
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

        if (method_exists($model, 'withoutGlobalScopes')) {
            $this->query->withoutGlobalScopes();
        }

        $this->query->orderByRaw($this->orderBy);
    }

    public function searchable()
    {
        return method_exists($this->newInstance, 'scopeSearch') ? true : false;
    }

    public function trashed($trash)
    {
        if ($this->softDeletes) {
            return $trash == 'only' ? $this->query->onlyTrashed() : $this->query->withTrashed();
        }

        return $this->query;
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
