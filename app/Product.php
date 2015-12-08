<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ThisVessel\Caravel\Traits\Crudable;

class Product extends Model
{
    use Crudable;

    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    protected $crud = [
        'title' => 'required',
        'description' => 'required',
        // 'price' => 'type:markdown|required',
    ];
}
