<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Seeds extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		\App\Field::create([
			'name' => 'male',
			'title' => '男',
			'field_class' => 'gender',
		])->create([
			'name' => 'female',
			'title' => '女',
			'field_class' => 'gender',
		])->create([
			'name' => 'news',
			'title' => '订阅号',
			'field_class' => 'wechat_type',
		])->create([
			'name' => 'service',
			'title' => '服务号',
			'field_class' => 'wechat_type',
		])->create([
			'name' => 'enterprise',
			'title' => '企业号',
			'field_class' => 'wechat_type',
		])->create([
			'name' => 'depots',
			'title' => '素材',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'news',
			'title' => '图文',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'image',
			'title' => '图片',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'thumb',
			'title' => '缩略图',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'video',
			'title' => '视频',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'voice',
			'title' => '音频',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'music',
			'title' => '音乐',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'text',
			'title' => '文字',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'link',
			'title' => '连接',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'location',
			'title' => '地址',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'callback',
			'title' => '回调',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'event',
			'title' => '事件',
			'field_class' => 'wechat_message_type',
		])->create([
			'name' => 'subscribe',
			'title' => '关注',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'unsubscribe',
			'title' => '取消关注',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'SCAN',
			'title' => '扫描二维码',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'LOCATION',
			'title' => '地址',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'CLICK',
			'title' => '点击',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'VIEW',
			'title' => '视图',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'scancode_push',
			'title' => '扫描事件',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'scancode_waitmsg',
			'title' => '扫描事件「非跳转」',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'pic_sysphoto',
			'title' => '系统拍照发图',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'pic_photo_or_album',
			'title' => '拍照或者相册发图',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'pic_weixin',
			'title' => '相册发图',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => 'location_select',
			'title' => '地址选择',
			'field_class' => 'wechat_event_type',
		])->create([
			'name' => '',
			'title' => '无',
		])->update(['id' => 0]);

		\App\Role::create([
			'id' => 99,
			'name' => 'admin',
			'display_name' => 'Adminsitrator Group'
		])->create([
			'id' => 98,
			'name' => 'manger',
			'display_name' => 'Manager Group'
		])->create([
			'id' => 97,
			'name' => 'owner',
			'display_name' => 'Owner Group'
		])->create([
			'id' => 96,
			'name' => 'leader',
			'display_name' => 'Leader Group'
		])->create([
			'id' => 1,
			'name' => 'viewer',
			'display_name' => 'Viewer Group'
		])->create([
			'id' => 2,
			'name' => 'wechater',
			'display_name' => 'Wechater Group'
		])->create([
			'id' => 0,
			'name' => 'guest',
			'display_name' => 'Guest Group'
		])->update(['id' => 0]);

		(new \App\User)->add([
			'username' => 'admin',
			'password' => '123456',
			'nickname' => 'Administrator',
		], \App\Role::ADMIN);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{

	}
}
