<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;

use Addons\Core\Models\Wechat\API;
use Addons\Core\Models\Wechat\User as WechatUserModel;


class WechatController extends Controller {
	use DispatchesJobs;

	public $wechatUser;
	public $user;
	/**
	 * 
	 */
	public function __construct()
	{

	}

	/**
	 * 微信推送接口，自动添加用户
	 * 
	 * @return boolean
	 */
	public function push($id = 0)
	{
		$account = WechatAccount::findOrFail($id);

		$api = new API($account->toArray(), $account->id);
		$wechatUserModel = new WechatUserModel($api);

		$api->valid();
		$rev = $api->getRev();
		$type = $rev->getRevType();
		$from = $rev->getRevFrom();
		$to = $rev->getRevTo();

		$this->wechatUser = $wechatUserModel->updateWechatUser($from);
		//如果不希望加入到用户表，请注释下行
		$this->user = $wechatUserModel->bindToUser($this->wechatUser);
		switch($type) {
			case API::MSGTYPE_TEXT: //文字消息
				return $this->text($api, $from, $to, $rev->getRevContent(), $rev->getRevID());
			case API::MSGTYPE_IMAGE: //图片消息
				return $this->image($api, $from, $to, $rev->getRevPic(), $rev->getRevID());
			case API::MSGTYPE_VOICE: //音频消息
				return $this->voice($api, $from, $to, $rev->getRevVoice(), $rev->getRevID());
			case API::MSGTYPE_VIDEO: //视频消息
				return $this->video($api, $from, $to, $rev->getRevVideo(), $rev->getRevID());
			case API::MSGTYPE_LOCATION: //地址消息
				return $this->location($api, $from, $to, $rev->getRevGeo(), $rev->getRevID());
			case API::MSGTYPE_LINK: //链接消息
				return $this->link($api, $from, $to, $rev->getRevLink(), $rev->getRevID());
			case API::MSGTYPE_EVENT: //事件
				$event = $rev->getRevEvent();
				switch ($event['event']) { 
					case 'subscribe':
						if (empty($event['key']))//关注微信
							return $this->subscribe($api, $from, $to);
						else //扫描关注
							return $this->scan_subscribe($api, $from, $to, $rev->getRevSceneId(), $rev->getRevTicket());
					case 'unsubscribe': //取消关注
						return $this->unsubscribe($api, $from, $to);
					case 'SCAN': //扫描二维码
						return $this->scan($api, $from, $to, $event['key'], $rev->getRevTicket());
					case 'LOCATION': //地址推送
						return $this->location_event($api, $from, $to, $rev->getRevEventGeo());
					case 'CLICK': //点击
						return $this->click($api, $from, $to, $event['key']);
					case 'VIEW': //跳转
						return $this->view($api, $from, $to, $event['key']);
					case 'scancode_push': //扫码推事件的事件推送
						return $this->scancode_push($api, $from, $to, $event['key'], $rev->getRevScanInfo());
					case 'scancode_waitmsg': //扫码推事件且弹出“消息接收中”提示框的事件推送
						return $this->scancode_waitmsg($api, $from, $to, $event['key'], $rev->getRevScanInfo());
					case 'pic_sysphoto': //弹出系统拍照发图的事件推送
						return $this->pic_sysphoto($api, $from, $to, $event['key'], $rev->getRevSendPicsInfo());
					case 'pic_photo_or_album': //弹出拍照或者相册发图的事件推送
						return $this->pic_photo_or_album($api, $from, $to, $event['key'], $rev->getRevSendPicsInfo());
					case 'pic_weixin': //弹出微信相册发图器的事件推送
						return $this->pic_weixin($api, $from, $to, $event['key'], $rev->getRevSendPicsInfo());
					case 'location_select': //弹出微信地址选择的事件推送
						return $this->location_select($api, $from, $to, $event['key'], $rev->getRevSendGeoInfo());
					
				}
				break;
		}
	}

	/**
	 * 文字消息
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $content 内容
	 * @param  string $msg_id  消息ID
	 * @return boolean
	 */
	protected function text($api, $from, $to, $content, $msg_id)
	{

	}

	/**
	 * 图片消息
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  array $data     图片内容 ['mediaid' => '', 'picurl'=>'']
	 * @param  string $msg_id  消息ID
	 * @return boolean
	 */
	protected function image($api, $from, $to, $data, $msg_id)
	{
		
	}

	/**
	 * 音频消息
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  array $data     音频内容 ['mediaid' => '', 'format' => '']
	 * @param  string $msg_id  消息ID
	 * @return boolean
	 */
	protected function voice($api, $from, $to, $data, $msg_id)
	{
		
	}

	/**
	 * 视频消息
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  array $data     视频内容 ['mediaid' => '', 'thumbmediaid' => '']
	 * @param  string $msg_id  消息ID
	 * @return boolean
	 */
	protected function video($api, $from, $to, $data, $msg_id)
	{
		
	}

	/**
	 * 地址消息
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  array $data     地址内容 ['x' => '', 'y' => '', 'scale' => '', 'label' => '']
	 * @param  string $msg_id  消息ID
	 * @return boolean
	 */
	protected function location($api, $from, $to, $data, $msg_id)
	{
		
	}

	/**
	 * 链接消息
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  array $data     链接内容 ['url' => '', 'title' => '', 'description' => '']
	 * @param  string $msg_id  消息ID
	 * @return boolean
	 */
	protected function link($api, $from, $to, $data, $msg_id)
	{
		
	}

	/**
	 * 关注
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @return boolean
	 */
	protected function subscribe($api, $from, $to)
	{
		$api->news(array( 0 =>
		 array(
			'Title'=>'欢迎收听',
			'Description'=>$this->user['nickname'].'，欢迎收听微信！',
			'PicUrl'=>'',
			'Url'=>''
			)
			))->reply();
	}

	/**
	 * 取消关注
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @return boolean
	 */
	protected function unsubscribe($api, $from, $to)
	{
		
	}

	/**
	 * 扫描关注
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $scene_id 二维码的参数值
	 * @param  string $ticket   二维码的ticket，可用来换取二维码图片
	 * @return boolean
	 */
	protected function scan_subscribe($api, $from, $to, $scene_id, $ticket)
	{
		
	}

	/**
	 * 扫描
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $scene_id 二维码的参数值
	 * @param  string $ticket   二维码的ticket，可用来换取二维码图片
	 * @return boolean
	 */
	protected function scan($api, $from, $to, $scene_id, $ticket)
	{
		
	}

	/**
	 * 上报地理位置事件
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  array $data     地理信息 ['x' => '', 'y' => '', 'precision' => '']
	 * @return boolean
	 */
	protected function location_event($api, $from, $to, $data)
	{
		
	}

	/**
	 * 自定义菜单事件
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $key     与自定义菜单接口中KEY值对应
	 * @return boolean
	 */
	protected function click($api, $from, $to, $key)
	{
		
	}

	/**
	 * 点击菜单跳转链接时的事件推送
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $url     设置的跳转URL
	 * @return boolean
	 */
	protected function view($api, $from, $to, $url)
	{
		
	}

	/**
	 * 扫码推事件的事件推送
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $key     由开发者在创建菜单时设定
	 * @param  array $scan_info 扫描信息 [ 'ScanType'=>'qrcode', 'ScanResult'=>'']
	 * @return boolean
	 */
	protected function scancode_push($api, $from, $to, $key, $scan_info)
	{
		
	}

	/**
	 * 扫码推事件且弹出“消息接收中”提示框的事件推送
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $key     由开发者在创建菜单时设定
	 * @param  array $scan_info 扫描信息 [ 'ScanType'=>'qrcode', 'ScanResult'=>'']
	 * @return boolean
	 */
	protected function scancode_waitmsg($api, $from, $to, $key, $scan_info)
	{

	}

	/**
	 * 弹出系统拍照发图的事件推送
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $key     由开发者在创建菜单时设定
	 * @param  array $send_pics_info 发送的图片信息 ['Count' => '2', 'PicList' =>['item' => [ ['PicMd5Sum' => 'aaae42617cf2a14342d96005af53624c'], ['PicMd5Sum' => '149bd39e296860a2adc2f1bb81616ff8'] ] ] ]
	 * @return boolean
	 */
	protected function pic_sysphoto($api, $from, $to, $key, $send_pics_info)
	{

	}

	/**
	 * 弹出拍照或者相册发图的事件推送
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $key     由开发者在创建菜单时设定
	 * @param  array $send_pics_info 发送的图片信息 ['Count' => '2', 'PicList' =>['item' => [ ['PicMd5Sum' => 'aaae42617cf2a14342d96005af53624c'], ['PicMd5Sum' => '149bd39e296860a2adc2f1bb81616ff8'] ] ] ]
	 * @return boolean
	 */
	protected function pic_photo_or_album($api, $from, $to, $key, $send_pics_info)
	{

	}

	/**
	 * 弹出微信相册发图器的事件推送
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $key     由开发者在创建菜单时设定
	 * @param  array $send_pics_info 发送的图片信息 ['Count' => '2', 'PicList' =>['item' => [ ['PicMd5Sum' => 'aaae42617cf2a14342d96005af53624c'], ['PicMd5Sum' => '149bd39e296860a2adc2f1bb81616ff8'] ] ] ]
	 * @return boolean
	 */
	protected function pic_weixin($api, $from, $to, $key, $send_pics_info)
	{

	}

	/**
	 * 弹出地理位置选择器的事件推送
	 * 
	 * @param  string $from    发送者OPENID
	 * @param  string $to      接收者OPENID
	 * @param  string $key     由开发者在创建菜单时设定
	 * @param  array $send_geo_info 发送的位置信息 ['Location_X' => '', 'Location_Y' => '', 'Scale' => '', 'Label' => '', 'Poiname' => '']
	 * @return boolean
	 */
	protected function location_select($api, $from, $to, $key, $send_geo_info)
	{

	}



}