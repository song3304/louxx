<?php

namespace App\Http\Controllers\Property;

use Illuminate\Http\Request;
use App\Properter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

abstract class BaseController extends Controller{
	public $properter = null;

	public function callAction($method, $parameters)
	{
	    $this->user = Auth::guard()->user();
	    $this->properter = Properter::with(['bulidings'])->find($this->user->getKey());
	    
	    if (empty($this->properter))
	        return $this->error('properter.failure_noexists',url('/auth'));

	    $this->building_ids = !empty($this->properter->bulidings)?$this->properter->bulidings->pluck('id')->toArray():[0];
	    $this->viewData['_properter'] = $this->properter;
		return parent::callAction($method, $parameters);
	}


}