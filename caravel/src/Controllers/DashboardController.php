<?php

namespace ThisVessel\Caravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function page()
    {
        $data['prefix'] = '/' . config('caravel.route_prefix');

        return view('caravel::pages.dashboard', $data);
    }
}
