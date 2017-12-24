<?php

namespace ThisVessel\Caravel;

use Schema;
use ThisVessel\Caravel\Traits\DbalHelpers;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Resource
{
    use DbalHelpers;

    public $name;
    public $className;
    public $newInstance;
    public $fillable;
    public $orderBy;
    public $fields;
    public $relations;
    public $rules;
    public $query;
    public $softDeletes;
    public $formPartial;

    public function __construct($resource)
    {
        $this->setName($resource);
        $this->setClassName();
        $this->setNewInstance();
        $this->setFillable();
        $this->setOrderBy();
        $this->setFields();
        $this->setRelations();
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

    protected function setFillable()
    {
        $forget = ['form', 'orderBy'];
        $caravel = $this->newInstance->caravel ? $this->newInstance->caravel : [];
        $fillable = array_values(array_diff(array_keys($caravel), $forget));

        if (empty($fillable)) {
            return abort(403, 'Fillable fields required in model\'s $caravel config.');
        }

        $this->fillable = $fillable;

        $this->newInstance->fillable($fillable);
    }

    protected function setOrderBy()
    {
        if (isset($this->newInstance->caravel['orderBy'])) {
            return $this->orderBy = $this->newInstance->caravel['orderBy'];
        }

        if (Schema::hasColumn($this->newInstance->getTable(), $this->newInstance->getUpdatedAtColumn())) {
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
            $nullable = $this->getNullable($model, $name);
            $options = isset($model->caravel[$name]) ? $model->caravel[$name] : null;
            $this->fields[$name] = new Field($name, $type, $nullable, $options);
        }
    }

    protected function setRelations()
    {
        $this->relations = [];

        foreach ($this->fields as $field) {
            if ($field->relation) {
                $this->relations[$field->name] = $field->relation;
            }
        }
    }

    protected function setSoftDeletes()
    {
        if (method_exists($this->newInstance, 'getDeletedAtColumn')) {
            return $this->softDeletes = $this->newInstance->getDeletedAtColumn();
        }

        return false;
    }

    protected function setFormPartial()
    {
        if (isset($this->newInstance->caravel['form'])) {
            return $this->formPartial = $this->newInstance->caravel['form'];
        }

        $this->formPartial = 'default';
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

    protected function setQueryBuilder()
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

    public function bindable($model = null)
    {
        if (! $model) {
            $model = $this->newInstance;
        }

        foreach ($this->relations as $fieldName => $relation) {
            if ($model->{$relation}() instanceof BelongsTo) {
                $bindable[$fieldName] = $model->{$relation}->{$model->getKeyName()};
            } elseif ($model->{$relation}() instanceof BelongsToMany) {
                $bindable[$fieldName] = $model->{$relation}->pluck($model->getKeyName())->toArray();
            }
        }

        foreach ($this->fields as $field) {
            if (! $model->getKey() && $field->default) {
                $bindable[$field->name] = $field->default;
            }
        }

        return isset($bindable)
            ? array_merge($model->getAttributes(), $bindable)
            : $model->getAttributes();
    }

    public function createWithRelations($request)
    {
        return $this->saveWithRelations($request, $this->newInstance);
    }

    public function updateWithRelations($request, $model)
    {
        return $this->saveWithRelations($request, $model);
    }

    protected function saveWithRelations($request, $model)
    {
        $relations = $this->relations;
        $input = $request->except(array_keys($relations));
        $inputNullable = $this->mapNullable($input);

        $model->fillable($this->fillable);
        $model->fill($inputNullable);

        foreach ($relations as $field => $relation) {
            if ($model->{$relation}() instanceof BelongsTo) {
                $model->{$relation}()->associate($request->get($field, null));
            }
        }

        $model->save();

        foreach ($relations as $field => $relation) {
            if ($model->{$relation}() instanceof BelongsToMany) {
                $model->{$relation}()->sync($request->get($field, []));
            }
        }

        return $model;
    }

    protected function mapNullable($input)
    {
        $fields = $this->fields;

        return collect($input)->map(function($value, $key) use ($fields) {
            $nullable = isset($fields[$key]) ? $fields[$key]->nullable : false;
            return $nullable && $value === '' ? null : $value;
        })->toArray();
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
