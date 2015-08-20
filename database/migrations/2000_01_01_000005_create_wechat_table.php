<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wechat_accounts', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 150); //名称
			$table->string('description', 255); //简介
			$table->string('appid', 50)->unique(); //appid
			$table->string('token', 150); //token
			$table->string('appsecret', 100); //token
			$table->string('encodingaeskey', 100)->nullable(); //encodingaeskey
			$table->timestamps();
			$table->softDeletes(); //软删除
		});
		Schema::create('wechat_users', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('waid'); //account_id
			$table->string('openid', 150)->index(); //OpenID
			$table->string('nickname', 50); //昵称
			$table->unsignedInteger('gender'); //性别
			$table->string('token', 150); //token
			$table->string('appsecret', 100); //token
			$table->string('encodingaeskey', 100)->nullable(); //encodingaeskey
			$table->timestamps();
			$table->softDeletes(); //软删除
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fields');
	}
}
