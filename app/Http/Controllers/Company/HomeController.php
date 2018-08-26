<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Salon\BaseController;

use App\BeautySalon;
use Addons\Core\Controllers\AdminTrait;
use App\Order;

class HomeController extends BaseController {

	public function index()
	{
		return $this->view('salon-backend.dashborad');
	}
}