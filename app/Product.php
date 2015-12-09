<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    public $caravel = [
        'title' => 'required',
        'description' => 'required|type:simplemde',
    ];
}
