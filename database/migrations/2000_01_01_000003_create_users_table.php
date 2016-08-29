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
			$table->string('username', 150)->unique()->comment = '用户名(账号)'; //用户名
			$table->string('password', 60)->comment = '密码'; //密码
			$table->string('nickname', 50)->nullable()->comment = '昵称'; //昵称
			$table->string('realname', 50)->nullable()->comment = '真实姓名'; //真实姓名
			$table->unsignedInteger('avatar_aid')->default(0)->comment = '头像AID'; //头像
			$table->unsignedInteger('gender')->default(0)->comment = '性别'; //性别
			$table->string('email')->nullable()->comment = 'Email'; //Email
			$table->string('phone', 20)->index()->comment = '电话'; //电话
			$table->string('idcard', 50)->index()->comment = '身份证'; //身份证
			$table->unsignedInteger('editor_uid')->default(0)->_comment = '编辑 ID';

			$table->rememberToken(); //记住我的Token
			$table->timestamps(); //创建/修改时间
			$table->timestamp('lastlogin_at')->comment = '最后登录时间'; //最后登录时间
			$table->softDeletes(); //软删除

		});

		Schema::create('user_finances', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->decimal('money', 16, 2)->index()->default(0)->comment = '余额';
			$table->decimal('used_money', 16, 2)->index()->default(0)->comment = '已消费金额';
			$table->decimal('bonus', 16, 2)->index()->default(0)->comment = '红包余额';
			$table->decimal('used_bonus', 16, 2)->index()->default(0)->comment = '已使用红包';
			$table->decimal('score', 16, 2)->index()->default(0)->comment = '积分余额';
			$table->decimal('used_score', 16, 2)->index()->default(0)->comment = '已使用积分';
			
			$table->timestamps(); //创建/修改时间
			$table->softDeletes(); //软删除

			$table->foreign('id')->references('id')->on('users')->onDelete('cascade');

		});
	
		Schema::create('password_resets', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('uid')->comment = '用户ID'; //UID
			$table->string('email')->index();
			$table->string('token')->index();
			$table->timestamp('created_at')->nullable();
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
