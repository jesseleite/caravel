<?php

namespace ThisVessel\Caravel;

use DB;

class Resource
{
    public $key;
    public $routePrefix;
    public $baseUri;
    public $modelClass;
    public $modelObject;
    public $fields;
    public $rules = [];

    public function __construct($resource)
    {
        $this->key = $resource;
        $this->setRoutePrefix();
        $this->setBaseUri();
        $this->setModelClass();
        $this->setModelObject();
        $this->setFields();
        $this->setRules();
    }

    protected function setRoutePrefix()
    {
        $this->routePrefix = '/' . config('caravel.route_prefix');
    }

    protected function setBaseUri()
    {
        $this->baseUri = $this->routePrefix . '/' . $this->key;
    }

    protected function setModelClass()
    {
        $this->modelClass = config('caravel.resources')[$this->key];
    }

    protected function setModelObject()
    {
        $this->modelObject = new $this->modelClass;
    }

    protected function setFields()
    {
        $model = $this->modelObject;

        $database = config('database.connections.mysql.database');
        $schema  = $model->getConnection()->getDoctrineSchemaManager($model->getTable());
        $columns = $schema->listTableColumns($model->getTable(), $database);

        foreach ($columns as $column) {
            $types[$column->getName()] = $column->getType();
        }

        foreach ($model->getFillable() as $name) {
            $type = $types[$name];
            $options = isset($model->caravel[$name]) ? $model->caravel[$name] : null;
            $this->fields[] = new Field($name, $type, $options);
        }
    }

    public function commonViewData()
    {
        return [
            'resource' => $this->key,
            'prefix'   => $this->routePrefix,
            'baseUri'  => $this->baseUri,
            'action'   => $this->baseUri,
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
        $model = $this->modelObject;

        return $model::find($id);
    }
}
