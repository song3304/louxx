<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Addons\Core\Controllers\WechatController as BaseWechatController;
use Addons\Core\Models\WechatUser;
use Addons\Core\Models\WechatDepotNews;
use Addons\Core\Tools\Wechat\API;
use Addons\Core\Tools\Wechat\User as WechatUserTool;
use App\Role;
use Auth;
class WechatController extends BaseWechatController {
	private $user = null;

	protected function user(API $api, WechatUser $wechatUser)
	{
		//如果不希望加入到系统的用户表，请注释下行
		return $this->user = (new WechatUserTool($api))->bindToUser($wechatUser, Role::WECHATER);
	}

	protected function auth(API $api, WechatUser $wechatUser)
	{
		if (!empty($wechatUser->user))
			return Auth::loginUsingId($wechatUser->uid);
	}

	public function news(Request $request, $id)
	{
		$news = WechatDepotNews::findOrFail($id);
		if ($news->redirect)
			return redirect($news['url']);

		return view('wechat')->with('news', $news);
	}

}