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
			$table->unsignedInteger('avatar_aid')->default(0); //头像
			$table->unsignedInteger('gender')->default(0); //性别
			$table->string('email')->nullable(); //Email
			$table->string('phone', 20)->index(); //电话
			$table->string('idcard', 50)->index(); //身份证

			$table->rememberToken(); //记住我的Token
			$table->timestamps(); //创建/修改时间
			$table->timestamp('lastlogin_at'); //最后登录时间
			$table->softDeletes(); //软删除

		});

		Schema::create('reset_password', function (Blueprint $table) {
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
