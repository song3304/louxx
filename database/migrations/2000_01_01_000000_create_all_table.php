<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role', function (Blueprint $table) {
			$table->increments('rid');
			$table->string('role_name', 150);
			$table->string('description')->nullable();
			$table->json('roles')->nullable();
			$table->timestamps();
			$table->softDeletes(); //软删除
		});

		Schema::create('member', function (Blueprint $table) {
			$table->increments('uid');
			$table->string('username', 150)->unique(); //用户名
			$table->string('password', 60); //密码
			$table->string('email')->nullable(); //Email
			$table->string('phone', 20); //电话
			$table->unsignedInteger('gender')->default(0); //性别
			$table->unsignedInteger('rid')->default(0); //组ID

			$table->rememberToken(); //记住我的Token
			$table->timestamps(); //创建/修改时间
			$table->timestamp('lastlogin_at'); //最后登录时间
			$table->softDeletes(); //软删除

			$table->foreign('rid')->references('rid')->on('role')->onDelete('cascade');
			
		});

		Schema::create('member_reset', function (Blueprint $table) {
			$table->increments('mrid');
			$table->unsignedInteger('uid'); //UID
			$table->string('token', 150)->index(); //Token
			$table->timestamps();

			$table->foreign('uid')->references('uid')->on('member')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
		Schema::drop('reset_password');
	}
}
