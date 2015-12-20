<?php

namespace ThisVessel\Caravel\Controllers;

use Illuminate\Routing\Controller;

class FileController extends Controller
{
    public function response($entity)
    {
        // Example of how to return response for file in storage folder?
        return response()->download(storage_path('app/uploads/podcasts/85/test-image.jpg'), null, [], null);
    }
}
