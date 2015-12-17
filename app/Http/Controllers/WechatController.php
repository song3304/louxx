<?php
namespace App\Http\Controllers;

use Addons\Core\Controllers\WechatController as BaseWechatController;
use Addons\Core\Models\WechatUser;
use Addons\Core\Tools\Wechat\API;
use Addons\Core\Tools\Wechat\User as WechatUserTool;
use Auth;
class WechatController extends BaseWechatController {

	protected function user(API $api, WechatUser $wechatUser)
	{
		//如果不希望加入到系统的用户表，请注释下行
		return (new WechatUserTool($api))->bindToUser($wechatUser);
	}

	protected function auth(API $api, WechatUser $wechatUser)
	{
		if (!empty($wechatUser->user))
			return Auth::loginUsingId($wechatUser->uid)
	}

	public function news(Request $request, $id)
	{
		$news = WechatDepotNews::findOrFail($id);
		if ($news->redirect)
			return redirect($news['url']);

		return view('wechat')->with('news', $news);
	}

}