<?php

namespace ThisVessel\Caravel\Traits;

use DB;
use ThisVessel\Caravel\Field;

trait Crudable
{
    public function getCrudFields()
    {
        // Yucky code...
        $database = config('database.connections.mysql.database');
        $columns = DB::select( DB::raw('SHOW COLUMNS FROM ' . $database . '.'. $this->getTable()));
        foreach($columns as $column){
            $types[$column->Field] = $column->Type;
        }
        // End of yucky code.

        foreach ($this->getFillable() as $name) {
            $type = $types[$name];
            $options = isset($this->crud[$name]) ? $this->crud[$name] : null;
            $fields[] = new Field($name, $type, $options);
        }

        return $fields;
    }
}
