<?php

namespace App\Core\Http\Controllers;

use Illuminate\Http\Request;

class HomeCoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['loginTemp']);
    }

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index()
    {
        return view('front::home');
    }

    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function loginTemp()
    {
        return view('front::auth.login');
    }
}
