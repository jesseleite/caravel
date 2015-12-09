<?php

namespace ThisVessel\Caravel;

class Resource
{
    public $key;
    public $routePrefix;
    public $baseUri;
    public $modelClass;
    public $modelObject;
    public $fields;

    public function __construct($resource)
    {
        $this->key = $resource;
        $this->setRoutePrefix();
        $this->setBaseUri();
        $this->setModelClass();
        $this->setModelObject();
        $this->setFields();
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
        $this->fields = $this->modelObject->getCrudFields();
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

    public function validationRules()
    {
        $rules = [];

        foreach ($this->fields as $field) {
            if ($field->required) {
                $rules[$field->name] = 'required';
            }
        }

        return $rules;
    }

    public function find($id)
    {
        $model = $this->modelObject;

        return $model::find($id);
    }
}
