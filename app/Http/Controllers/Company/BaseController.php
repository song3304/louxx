<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BeautySalon;
use Addons\Core\Controllers\AdminTrait;

abstract class BaseController extends Controller{

	public $salon = null;

	public function __construct()
	{
		parent::__construct();

		$this->salon = BeautySalon::find($this->user->getKey());
		if (empty($this->salon)) 
			return $this->error('salon.failure_noexists');

		$this->viewData['_salon'] = $this->salon;
	}


}