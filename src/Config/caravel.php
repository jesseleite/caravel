<?php

return [

    'resources' => [
        // 'products' => App\Product::class,
    ],

    'prefix' => 'caravel',

    'pagination' => 25,

    'auth' => [
        'login' => null,
        'logout' => null,
    ],

    'upload' => [
        'path' => public_path() . '/uploads/:table/:id',
    ],

];
