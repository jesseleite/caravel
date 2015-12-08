<?php

namespace ThisVessel\Caravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ThisVessel\Caravel\Traits\GetRoutePrefix;

class DashboardController extends Controller
{
    use GetRoutePrefix;

    public function page()
    {
        $data['prefix'] = $this->getRoutePrefix();

        return view('caravel::dashboard', $data);
    }
}
