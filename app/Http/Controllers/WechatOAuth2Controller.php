<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Plugins\Wechat\App\Http\Controllers\WechatOAuth2Controller as BaseWechatOAuth2Controller;
use Addons\Core\Validation\ValidatesRequests;
use App\Role;
use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\Tools\API;
use Plugins\Wechat\App\Tools\OAuth2;
use Plugins\Wechat\App\Tools\Js;
use Illuminate\Support\Facades\Auth;

class WechatOAuth2Controller extends BaseWechatOAuth2Controller
{
    use DispatchesJobs, ValidatesRequests;
    
    protected $wechat_oauth2_account = 1;
    //protected $wechat_oauth2_bindUserRole = 'user1';//不绑定微信到用户表
    protected $must_weixin = false;
    
    public function callAction($method, $parameters)
    {
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            if (!empty($this->wechat_oauth2_account))
            {
                $account = WechatAccount::findOrFail($this->wechat_oauth2_account);
                $oauth2 = new OAuth2($account->toArray(), $account->getKey());
            
                $this->wechatUser = $oauth2->getUser();
                if (empty($this->wechatUser))
                {
                    //ajax 请求则报错
                    if (app('request')->ajax())
                        return $this->failure('wechat::wechat.failure_ajax_oauth2');
            
                    $this->wechatUser = $oauth2->authenticate(NULL, $this->wechat_oauth2_type, $this->wechat_oauth2_bindUserRole);
                }
                $this->user = Auth::guard()->user();
                if(empty($this->user)){
                    $userModel = config('auth.providers.users.model');
                    //$this->wechat_oauth2_bindUserRole && $this->user = (new $userModel)->find($this->wechatUser->uid);
                    if(!empty($this->wechatUser->uid)){
                        $this->user = (new $userModel)->find($this->wechatUser->uid);
                        Auth::guard()->loginUsingId($this->user->getKey());
                    }
                } 
            }
            $this->_is_weixin = true;
        }else{
            $this->user = Auth::guard()->user();
            $this->wechatUser = null;
            $this->_is_weixin = false;
        }
        return parent::callAction($method, $parameters);
    }
}
