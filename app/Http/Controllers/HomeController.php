<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'activateSuccess', 'activateError']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function activateSuccess()
    {
        return view('auth.activate_success');
    }

    public function activateError()
    {
        return view('auth.activate_error');
    }

    public function about()
    {
        return view('welcome', compact('data', []));
    }

}
