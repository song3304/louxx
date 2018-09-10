<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Queue;
use Illuminate\Support\Str;
use App\User;
use Session;
use App\FindBuilding;

class FindBuildingController extends Controller
{
	public function index(Request $request)
	{
	    $keys = ['province', 'city', 'area', 'rent_low', 'rent_high','phone','valid_code'];
		$this->_validates = $this->getScriptValidate('find-building.store', $keys);
		return $this->view('index.find_building');
	}

    // 处理用户提交找楼请求
	public function apply(Request $request){
	   $keys = ['province', 'city', 'area', 'rent_low', 'rent_high','phone','valid_code'];
	   $data = $this->autoValidate($request, 'find-building.store', $keys);
       
	   //验证手机验证码
	   //......
	   unset($data['valid_code']);
	   $user = (new FindBuilding)->add($data);
	   return $this->success(NULL, url('findBuilding/submit'), $user->toArray());
	}
	
	// 提交成功
	public function submit(Request $request)
	{
	    return $this->view('index.find_building_submit');
	}
}
