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
use App\Tools\HxSmsApi;
use Cache;
use App\Area;

class FindBuildingController extends WechatOAuth2Controller
{
	public function index(Request $request)
	{
	    $keys = ['province', 'city', 'area', 'rent_low', 'rent_high','phone','validate_code','note'];
		$this->_validates = $this->getScriptValidate('find-building.store', $keys);
		return $this->view('index.find_building');
	}

    // 处理用户提交找楼请求
	public function apply(Request $request){
	   $keys = ['province', 'city', 'area', 'rent_low', 'rent_high','phone','validate_code','note'];
	   $data = $this->autoValidate($request, 'find-building.store', $keys);
       
	   // 验证手机
	   if(!(new HxSmsApi)->checkPhoneCode($data['phone'],$data['validate_code'])){
	       return $this->failure('apply.failure_phone_validate_code');
	   }
	   
	   unset($data['validate_code']);
	   //自动添加登录用户
	   $user = Auth::guard()->user();
	   if(!empty($user)){
	       $data['uid'] = $this->user->getKey();
	   }
	   $find_building = (new FindBuilding)->create($data);
	   return $this->success('findbuilding.submit_success', url('home/index'));
	}
	
	// 提交成功
	public function submit(Request $request)
	{
	    return $this->view('index.find_building_submit');
	}
	public function data(Request $request)
	{
	    $area = new Area;
	    $builder = $area->newQuery();
	
	    $total = $this->_getCount($request, $builder, FALSE);
	    $builder = $builder->orderBy('area_id','asc');
	    $data = $this->_getData($request, $builder, null);
	    $data['recordsTotal'] = $total; //不带 f q 条件的总数
	    $data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
	    return $this->api($data);
	}
	// 用户发送验证码
	public function sendCode(Request $request)
	{
	    $phone = $request->input('phone');
	    if (!preg_match('/^1\d{10}$/',$phone)) {
	        return $this->error("手机号非法");
	    }
	     
	    $valid_phone_key = 'valid_phone_code_time_'.$phone;
	    $delta_time = time() - intval(Cache::get($valid_phone_key,0));
	    if ($delta_time <= 60) {
	        //60秒内只能发一次
	        return $this->error("发送短信频次太高");
	    }
	    //发送短信，则在此记录时间
	    $result = (new HxSmsApi)->sendSingleCodeSms($phone);
	    if ($result['result']) {
	        //发送成功
	        Cache::put($valid_phone_key, time(),5);
	        return $this->success('请注意查收短信');
	    } else {
	        return $this->error("发送验短信失败，请联系管理员");
	    }
	}
}
