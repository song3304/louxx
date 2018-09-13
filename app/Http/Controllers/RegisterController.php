<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Cache;
use App\Tools\HxSmsApi;

class RegisterController extends Controller
{
    // 注册首页
	public function index()
	{
	    $keys = ['phone', 'validate_code'];
	    $this->_validates = $this->getScriptValidate('member.register', $keys);
	    return $this->view('index.register');
	}

    // 用户注册,用户登录成功
	public function login(Request $request)
	{
		$keys = ['phone', 'validate_code'];
		$data = $this->autoValidate($request, 'member.register', $keys);

		$user = (new User)->add($data);
		return $this->success(NULL, url('home/index'), $user->toArray());
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
