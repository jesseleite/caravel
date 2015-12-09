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
        'title' => 'type:password|min:8',
        // 'description' => 'required|type:simplemde',
    ];
}
