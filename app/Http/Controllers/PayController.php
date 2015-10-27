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
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$wechatUser = $this->getWechatUser();
		$account = WechatAccount::find(1);
		$api = new API($account->toArray(), $account->getKey());

		$pay = new Pay($api);
		$order = (new UnifiedOrder('JSAPI', date('YmdHis'), '买单', 1))->SetAttach('说点什么好?')->SetNotify_url(url('wechat/feedback?id='.$account->getKey()))->SetOpenid($wechatUser->openid);
		$UnifiedOrderResult = $pay->unifiedOrder($order);
		
		$js = new Js($api);
		$this->_parameters = $js->getPayParameters($UnifiedOrderResult);
		return $this->view('pay.index');
	}



}
