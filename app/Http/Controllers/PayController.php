<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\User;
use Addons\Core\Models\WechatAccount;
use Addons\Core\Tools\Wechat\API;
use Addons\Core\Tools\Wechat\Pay;
use Addons\Core\Tools\Wechat\Js;
use Addons\Core\Tools\Wechat\Pay\UnifiedOrder;

class PayController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$account = WechatAccount::find(1);
		$api = new API($account->toArray(), $account->getKey());

		$pay = new Pay($api);
		$order = (new UnifiedOrder('JSAPI', 123442, '买单', 1))->SetAttach('说点什么好?')->SetNotify_url(url('pay/feedback'))->SetOpenid('omwYBuJ-FCQRuh2CdpLGWCuAIHNo');
		$UnifiedOrderResult = $pay->unifiedOrder($order);
		
		$js = new Js($api);
		$this->_parameters = $js->getPayParameters($UnifiedOrderResult);
		return $this->view('pay.index');
	}

	public function feedback()
	{

	}

}
