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
		\Addons\Core\Models\Field::create([
			'text' => 'Male',
			'field_class' => 'gender',
		])->create([
			'text' => 'Female',
			'field_class' => 'gender',
		])->create([
			'text' => 'None',
		])->update(['id' => 0]);

		\Addons\Core\Models\Role::create([
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
			'id' => 0,
			'name' => 'guest',
			'display_name' => 'Guest Group'
		])->update(['id' => 0]);

		(new \Addons\Core\Models\User)->add([
			'username' => 'admin',
			'password' => '123456',
			'nickname' => 'Administrator',
		], \Addons\Core\Models\Role::ADMIN);
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
