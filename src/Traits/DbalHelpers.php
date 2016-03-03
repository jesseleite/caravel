<?php

namespace ThisVessel\Caravel\Traits;

use Doctrine\DBAL\Types\Type;

trait DbalHelpers
{
    /**
     * Scan model table and return DBAL field types.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return array
     */
    public function getDbalTypesFromModel($model)
    {
        $schema  = $model->getConnection()->getDoctrineSchemaManager($model->getTable());
        $columns = $schema->listTableColumns($model->getTable());

        foreach ($columns as $column) {
            $types[$column->getName()] = $column->getType();
        }

        return $types;
    }

    /**
     * Factory method to create dbal type instances.
     *
     * @param  string  $type
     * @return \Doctrine\DBAL\Types\Type
     */
    public function getDbalTypeInstance($type)
    {
        return Type::getType($type);
    }

    /**
     * Check if column is nullable.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $column
     * @return bool
     */
    public function getNullable($model, $column)
    {
        $schema = $model->getConnection()->getDoctrineSchemaManager($model->getTable());
        $columns = $schema->listTableColumns($model->getTable());

        return ! $columns[$column]->getNotnull();
    }
}
