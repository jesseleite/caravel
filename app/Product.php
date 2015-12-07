<?php

namespace App;

use ThisVessel\Caravel\Field;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    protected $crud = [
        'title' => 'type:text',
        'description' => 'type:textarea',
        'price' => 'type:markdown|required|search:id1,id2',
    ];

    public static function getCrudFields()
    {
        $model = (new static);
        $fields = [];

        foreach ($model->getFillable() as $field) {
            $options = isset($model->crud[$field]) ? $model->crud[$field] : null;
            $fields[] = new Field($model->getTable(), $field, $options);
        }

        return $fields;
    }
}
