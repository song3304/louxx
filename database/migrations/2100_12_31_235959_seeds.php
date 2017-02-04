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
		\DB::transaction(function() {
			\Illuminate\Database\Eloquent\Model::unguard(true);
			\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
			\DB::table('catalogs')->truncate();
			\DB::table('permission_role')->truncate();
			\DB::table('permission_user')->truncate();
			\DB::table('role_user')->truncate();
			\DB::table('permissions')->truncate();
			\DB::table('roles')->truncate();
			\DB::table('users')->truncate();
			\DB::table('user_finances')->truncate();
			\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

			\App\Catalog::forceCreate([
				'id' => 1,
				'name' => 'fields',
				'title' => '字段',
			])->forceCreate([
				'id' => 2,
				'name' => 'status',
				'title' => '状态',
			])->forceCreate([
				'id' => 3,
				'name' => 'news',
				'title' => '新闻',
			])->forceCreate([
				'id' => 4,
				'name' => '4',
				'title' => '',
			])->forceCreate([
				'id' => 5,
				'name' => '5',
				'title' => '',
			])->forceCreate([
				'id' => 6,
				'name' => '6',
				'title' => '',
			])->forceCreate([
				'id' => 7,
				'name' => '7',
				'title' => '',
			])->forceCreate([
				'id' => 8,
				'name' => '8',
				'title' => '',
			])->forceCreate([
				'id' => 9,
				'name' => '9',
				'title' => '',
			])->forceCreate([
				'id' => 10,
				'name' => '10',
				'title' => '',
			])->forceCreate([
				'id' => 0,
				'name' => '',
				'title' => '无'
			]);
			\DB::statement("ALTER TABLE `catalogs` AUTO_INCREMENT = 11;");
			\DB::statement("UPDATE `catalogs` SET `path` = '/0/', `id` = 0 WHERE `id` = 11;");

			$fields = [
				'gender|性别' => [
					'male|男' => [],
					'female|女' => [],
				],
			];
			$status = [
			];

			\App\Catalog::import($fields, \App\Catalog::findByName('fields'));
			\App\Catalog::import($status, \App\Catalog::findByName('status'));


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
				'name' => 'extra3',
				'display_name' => '其他用户组3',
				'url' => '',
			])->create([
				'id' => 4,
				'name' => 'extra4',
				'display_name' => '其它用户组4',
				'url' => '',
			])->create([
				'id' => 5,
				'name' => 'extra5',
				'display_name' => '其它用户组5',
				'url' => '',
			])->create([
				'id' => 6,
				'name' => 'extra6',
				'display_name' => '其它用户组6',
				'url' => '',
			])->create([
				'id' => 7,
				'name' => 'extra7',
				'display_name' => '其它用户组7',
				'url' => '',
			])->create([
				'id' => 8,
				'name' => 'extra8',
				'display_name' => '其它用户组8',
				'url' => '',
			])->create([
				'id' => 9,
				'name' => 'administrator',
				'display_name' => '管理用户组',
				'url' => '',
			])->create([
				'id' => 0,
				'name' => 'guest',
				'display_name' => '访客(无下级分类)',
				'url' => '',
			])->update(['id' => 0]);
			//添加受限 子项
			$role = \App\Role::findByName('forbidden')->children();
			$role->create([
				'id' => '-10',
				'name' => 'banned',
				'display_name' => '禁止登录',
				'url' => '',
			]);
			$role->create([
				'id' => '-9',
				'name' => 'zombie',
				'display_name' => '禁止交互',
				'url' => '',
			]);
			$role->create([
				'id' => '-2',
				'name' => 'pending',
				'display_name' => '待验证',
				'url' => '',
			]);
			\DB::statement("ALTER TABLE `roles` AUTO_INCREMENT = 10;");
			//添加管理员 子项
			$role = \App\Role::findByName('administrator')->children();
			$role->create([
				'name' => 'super',
				'display_name' => '超级管理员',
				'url' => 'admin',
			]);
			$role->create([
				'name' => 'manager',
				'display_name' => '产品经理',
				'url' => 'admin',
			]);
			$role->create([
				'name' => 'editor',
				'display_name' => '编辑',
				'url' => 'admin',
			]);
			//添加普通用户 子项
			$role = \App\Role::findByName('user')->children();
			$role->create([
				'name' => 'user1',
				'display_name' => '普通用户',
				'url' => '',
			]);
			$role->create([
				'name' => 'user2',
				'display_name' => '活跃用户',
				'url' => '',
			]);
			//添加VIP 子项
			$role = \App\Role::findByName('vip')->children();
			$role->create([
				'name' => 'vip1',
				'display_name' => 'VIP 1',
				'url' => '',
			]);
			$role->create([
				'name' => 'vip2',
				'display_name' => 'VIP 2',
				'url' => '',
			]);

			//添加权限
			foreach([
				'role' => '用户组、权限',
				'attachment' => '附件',
				'member' => '用户',
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

			\App\User::add([
				'username' => 'admin',
				'password' => '123456',
				'nickname' => '超级管理员',
			], 'super');
			\Illuminate\Database\Eloquent\Model::unguard(false);
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
