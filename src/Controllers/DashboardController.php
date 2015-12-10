<?php

namespace ThisVessel\Caravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function page()
    {
        if (! empty(config('caravel.route_prefix'))) {
            $data['prefix'] = '/' . config('caravel.route_prefix');
        } else {
            $data['prefix'] = null;
        }

        return view('caravel::pages.dashboard', $data);
    }
}
