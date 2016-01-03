<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Plugins\Wechat\App\Http\Controllers\WechatOAuth2Controller as BaseWechatOAuth2Controller;
use Addons\Core\Validation\ValidatesRequests;

abstract class WechatOAuth2Controller extends BaseWechatOAuth2Controller
{
    use DispatchesJobs, ValidatesRequests;
}
