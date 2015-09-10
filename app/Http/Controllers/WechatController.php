<?php
namespace App\Http\Controllers;

use Addons\Core\Controllers\WechatController as BaseWechatController;
use Addons\Core\Models\WechatUser;
use Addons\Core\Models\Wechat\API;
use Addons\Core\Models\Wechat\User as WechatUserModel;

class WechatController extends BaseWechatController {

	protected function user(API $api, WechatUser $wechatUser)
	{
		//如果不希望加入到系统的用户表，请注释下行
		(new WechatUserModel($api))->bindToUser($wechatUser);
	}
}