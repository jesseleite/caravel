<?php

namespace ThisVessel\Caravel;

use ThisVessel\Caravel\Traits\DbalFieldTypes;

class Resource
{
    use DbalFieldTypes;

    public $name;
    public $className;
    public $newInstance;
    public $fields;
    public $rules = [];

    public function __construct($resource)
    {
        $this->setName($resource);
        $this->setClassName();
        $this->setNewInstance();
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

    public function commonViewData()
    {
        return [
            'resource' => $this->name,
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

    public function find($id)
    {
        $model = $this->newInstance;

        return $model::find($id);
    }
}
