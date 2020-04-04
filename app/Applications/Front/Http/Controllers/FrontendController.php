<?php

namespace App\Applications\Front\Http\Controllers;

use App\Core\Http\Controllers\Controller;

class FrontendController extends Controller
{
    /**
     * Welcome page.
     *
     * @param Request $request
     * @return mixed
     */
    public function index()
    {
        return view('front::index');
    }

    /**
     * Welcome page.
     *
     * @param Request $request
     * @return mixed
     */
    public function about()
    {
        return view('front::about');
    }
}
