<?php

namespace ThisVessel\Caravel\Traits;

trait DbalFieldTypes
{
    /**
     * Insert model, get DBAL field types.
     *
     * @param  $model \Illuminate\Database\Eloquent\Model;
     * @return array  \Doctrine\DBAL\Types;
     */
    public function getTypesFromDbal($model)
    {
        $schema  = $model->getConnection()->getDoctrineSchemaManager($model->getTable());
        $columns = $schema->listTableColumns($model->getTable());

        foreach ($columns as $column) {
            $types[$column->getName()] = $column->getType();
        }

        return $types;
    }
}
