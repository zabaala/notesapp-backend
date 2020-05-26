<?php

namespace App\Core\Http\Controllers;

use Illuminate\Http\Request;

class ApiCoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }

    /**
     * Show welcome message.
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $data = [
            'version' => '1.0.0',
            'msg' => 'Welcome to NotesApp API',
            'documentation' => 'Coming Soon',
        ];

        return response()->json($data);
    }

    /**
     * Returns details
     *
     * @return json
     */
    public function details()
    {
        $data = [
            'version' => '1.0.0',
            'msg' => 'Some Details about the API',
            'documentation' => 'Coming Soon',
        ];

        return response()->json($data);
    }
}
