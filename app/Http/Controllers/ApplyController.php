<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Cache;
use App\Tools\HxSmsApi;
use App\ProperterApply;

//物业申请入驻
class ApplyController extends WechatOAuth2Controller
{
    // 物业申请入驻首页
	public function index()
	{
	    $keys = ['name', 'province','city','area','address','phone','note','validate_code'];
	    $this->_validates = $this->getScriptValidate('properter-apply.store', $keys);
	    return $this->view('index.apply_property');
	}

    // 物业申请入驻
	public function enter(Request $request)
	{
		$keys = ['name', 'province','city','area','address','phone','note','validate_code'];
		$data = $this->autoValidate($request, 'properter-apply.store', $keys);

		// 验证手机
		if(!(new HxSmsApi)->checkPhoneCode($data['phone'],$data['validate_code'])){
		    return $this->failure('apply.failure_phone_validate_code');
		}
		
		// 验证手机验证码...
		unset($data['validate_code']);
		//自动添加登录用户
		$user = Auth::guard()->user();
		if(!empty($user)){
		   $data['uid'] = $this->user->getKey();
		}
		
		$apply_info = (new ProperterApply)->create($data);
		return $this->success('apply.success', url('home/index'));
	}
	
	// 物业申请入驻提交成功
	public function submit(Request $request)
	{
	    return $this->view('index.apply_submit');
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
