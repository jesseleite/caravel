<?php

return [

    'resources' => [
        // 'products' => App\Product::class,
    ],

    'prefix' => 'caravel',

    'logout' => null,

    'upload' => [
        'path' => public_path() . '/uploads/:table/:id',
    ],

];
