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

    public function __construct($resource)
    {
        $this->setName($resource);
        $this->setClassName();
        $this->setNewInstance();
        $this->checkFillable();
        $this->setOrderBy();
        $this->setFields();
        $this->setRules();
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
        $types = $this->getTypesFromDbal($model);

        foreach ($model->getFillable() as $name) {
            $type = $types[$name];
            $options = isset($model->caravel[$name]) ? $model->caravel[$name] : null;
            $this->fields[] = new Field($name, $type, $options);
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

    public function query()
    {
        $model = $this->newInstance;
        $query = $model::orderByRaw($this->orderBy);

        if (method_exists($model, 'withoutGlobalScopes')) {
            $query = $query->withoutGlobalScopes();
        }

        return $query;
    }

    public function find($id)
    {
        $model = $this->newInstance;

        return $model::find($id);
    }
}
