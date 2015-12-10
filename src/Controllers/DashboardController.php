<?php

namespace ThisVessel\Caravel\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Display dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('caravel::pages.dashboard');
    }

    /**
     * Redirect to dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect()
    {
        return redirect()->route('caravel::dashboard');
    }
}
