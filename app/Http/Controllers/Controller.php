<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Addons\Core\Controllers\Controller as BaseController;
use Addons\Core\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use /*AuthorizesRequests,*/ DispatchesJobs, ValidatesRequests;
}
