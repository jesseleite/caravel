<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ThisVessel\Caravel\Traits\Crudable;

class Newsletter extends Model
{
    use Crudable;

    protected $fillable = [
        'title',
        'pdf',
    ];

    protected $crud = [
        // 'title' => 'type:text',
        // 'pdf' => 'type:dropzone',
    ];
}
