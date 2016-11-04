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
		$fill = function(&$data, $parentNode) use (&$fill) {
			foreach($data as $k => &$v)
			{
				list($name, $title) = explode('|', $k);
				$node = $parentNode->children()->create(compact('name', 'title'));
				!empty($v) && $fill($v, $node);
			}
		};

		\DB::transaction(function() use ($fill) {
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');
			\DB::table('catalogs')->truncate();
			\DB::table('permission_role')->truncate();
			\DB::table('permission_user')->truncate();
			\DB::table('role_user')->truncate();
			\DB::table('permissions')->truncate();
			\DB::table('roles')->truncate();
			\DB::table('users')->truncate();
			\DB::table('user_finances')->truncate();
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');

			\App\Catalog::create([
				'name' => 'fields',
				'title' => '字段',
			])->create([
				'name' => 'news',
				'title' => '新闻分类',
			])->create([
				'name' => '3',
				'title' => '',
			])->create([
				'name' => '4',
				'title' => '',
			])->create([
				'name' => '5',
				'title' => '',
			])->create([
				'name' => '6',
				'title' => '',
			])->create([
				'name' => '7',
				'title' => '',
			])->create([
				'name' => '8',
				'title' => '',
			])->create([
				'name' => '9',
				'title' => '',
			])->create([
				'name' => '10',
				'title' => '',
			])->create([
				'name' => 'none',
				'title' => '无'
			])->update(['id' => 0]);
			DB::statement("ALTER TABLE `catalogs` AUTO_INCREMENT = 11;");

			$fields = [
				'gender|性别' => [
					'male|男' => [],
					'female|男女' => [],
				],
				'wechat|微信' => [
					'wechat_type|公众号类型' => [
						'news|订阅号' => [],
						'service|服务号' => [],
						'enterprise|企业号' => [],
					],
					'wechat_message_type|消息类型' => [
						'depot|素材' => [],
						'news|图文' => [],
						'image|图片' => [],
						'thumb|缩略图' => [],
						'video|视频' => [],
						'shortvideo|小视频' => [],
						'voice|音频' => [],
						'music|音乐' => [],
						'text|文字' => [],
						'link|连接' => [],
						'location|地址' => [],
						'callback|回调' => [],
						'event|事件' => [],
					],
					'wechat_event_type|事件类型' => [
						'subscribe|关注' => [],
						'unsubscribe|取消关注' => [],
						'SCAN|扫描二维码' => [],
						'LOCATION|地址' => [],
						'CLICK|点击' => [],
						'VIEW|视图' => [],
						'scancode_push|扫描事件' => [],
						'scancode_waitmsg|扫描事件「非跳转」' => [],
						'pic_sysphoto|系统拍照发图' => [],
						'pic_photo_or_album|拍照或者相册发图' => [],
						'pic_weixin|相册发图' => [],
						'location_select|地址选择' => [],
					],
				],
			];

			$fill($fields, \App\Catalog::findByName('fields'));


			//新建用户组
			\App\Role::create([
				'id' => -1,
				'name' => 'forbidden',
				'display_name' => '受限用户组',
				'url' => '',
			])->create([
				'id' => 1,
				'name' => 'user',
				'display_name' => '普通用户组',
				'url' => '',
			])->create([
				'id' => 2,
				'name' => 'vip',
				'display_name' => 'VIP用户组',
				'url' => '',
			])->create([
				'id' => 3,
				'name' => 'administrator',
				'display_name' => '管理用户组',
				'url' => '',
			])->create([
				'id' => 0,
				'name' => 'guest',
				'display_name' => '访客(无下级分类)',
				'url' => '',
			])->update(['id' => 0]);
			DB::statement("ALTER TABLE `roles` AUTO_INCREMENT = 4;");

			//添加管理员 子项
			\App\Role::findByName('administrator')->children()
			->create([
				'name' => 'super',
				'display_name' => '超级管理员',
				'url' => 'admin',
			])
			->create([
				'name' => 'manager',
				'display_name' => '产品经理',
				'url' => 'admin',
			])
			->create([
				'name' => 'editor',
				'display_name' => '编辑',
				'url' => 'admin',
			]);
			//添加受限 子项
			\App\Role::findByName('forbidden')->children()
			->create([
				'id' => '-10',
				'name' => 'banned',
				'display_name' => '黑名单',
				'url' => 'admin',
			])
			->create([
				'id' => '-2',
				'name' => 'pending',
				'display_name' => '待验证',
				'url' => 'admin',
			]);

			//添加权限
			foreach([
				'role' => '用户组、权限',
				'attachment' => '附件',
				'member' => '用户',
				'wechat-account' => '微信公众号',
				'wechat-depot' => '微信素材',
				'wechat-menu' => '微信菜单',
				'wechat-message' => '微信消息',
				'wechat-reply' => '微信自定义回复',
				'wechat-user' => '微信用户',
			] as $k => $v) {
				foreach([
					'view' => '查看',
					'create' => '新建',
					'edit' => '编辑',
					'destroy' => '删除',
					'export' => '导出'
				] as $k1 => $v1) {
					\App\Permission::create([
						'name' => $k.'.'.$k1,
						'display_name' => '允许'.$v1.$v,
					]);
				}
			}
			\App\Role::findByName('super')->perms()->sync(\App\Permission::all());

			(new \App\User)->add([
				'username' => 'admin',
				'password' => '123456',
				'nickname' => '超级管理员',
			], 'super');

		});
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
