<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\WechatOAuth2Controller;
use Illuminate\Support\Str;
use App\User;
use Addons\Core\Models\WechatAccount;
use Addons\Core\Tools\Wechat\API;
use Addons\Core\Tools\Wechat\Pay;
use Addons\Core\Tools\Wechat\Js;
use Addons\Core\Tools\Wechat\Pay\UnifiedOrder;

class PayController extends WechatOAuth2Controller
{
	public $wechat_oauth2_account = 1;
	public $wechat_oauth2_type = 'snsapi_base'; // snsapi_base  snsapi_userinfo  hybrid
	public $wechat_oauth2_bindUser = TRUE; // 是否将微信用户绑定到系统用户users

	public function test()
	{
		$wechatUser = $this->getWechatUser();
		$account = WechatAccount::findOrFail($this->wechat_oauth2_account);
		$api = new API($account->toArray(), $account->getKey());

		$pay = new Pay($api);
		$order = (new UnifiedOrder('JSAPI', date('YmdHis'), '买1分钱的单', 1))->SetNotify_url(url('wechat/feedback/'.$account->getKey()))->SetOpenid($wechatUser->openid);
		$UnifiedOrderResult = $pay->unifiedOrder($order);
		$js = new Js($api);
		$this->_parameters = $js->getPayParameters($UnifiedOrderResult);
		return $this->view('pay.test');
	}

}
