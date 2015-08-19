<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('username', 150)->unique(); //用户名
			$table->string('password', 60); //密码
			$table->string('nickname', 50)->nullable(); //昵称
			$table->string('realname', 50)->nullable(); //真实姓名
			$table->unsignedInteger('avatar_aid')->nullable()->default(0); //头像
			$table->unsignedInteger('gender')->nullable()->default(0); //性别
			$table->string('email')->nullable(); //Email
			$table->string('phone', 20); //电话
			$table->unsignedInteger('rid')->default(0); //组ID

			$table->rememberToken(); //记住我的Token
			$table->timestamps(); //创建/修改时间
			$table->timestamp('lastlogin_at'); //最后登录时间
			$table->softDeletes(); //软删除

			//$table->foreign('avatar_aid')->references('id')->on('attachments');
			//$table->foreign('gender')->references('id')->on('fields');
		});

		Schema::create('user_reset', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('uid'); //UID
			$table->string('token', 150)->index(); //Token
			$table->timestamps();

			$table->foreign('uid')->references('id')->on('users')->onDelete('cascade');
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
