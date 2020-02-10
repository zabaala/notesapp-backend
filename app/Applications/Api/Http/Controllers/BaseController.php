<?php

namespace App\Applications\Api\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Support\Api\Traits\ResponseWithErrors;

class BaseController extends Controller
{
    use ResponseWithErrors;
}
