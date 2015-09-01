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
			$table->string('appsecret', 100); //appsecret
			$table->string('encodingaeskey', 100)->nullable(); //encodingaeskey
			$table->unsignedInteger('qr_aid')->nullable(); //二维码
			$table->timestamps();
		});
		Schema::create('wechat_users', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('waid'); //account_id
			$table->string('openid', 150)->index(); //OpenID
			$table->string('nickname', 50)->nullable(); //昵称
			$table->unsignedInteger('gender')->nullable()->default(0); //性别
			$table->unsignedInteger('avatar_aid')->nullable()->default(0); //头像
			$table->tinyInt('is_subscribe')->default(0); //是否关注
			$table->string('country',50)->nullable(); //国家
			$table->string('province',50)->nullable(); //省
			$table->string('city',50)->nullable(); //市
			$table->string('language',20)->nullable(); //语言
			$table->string('unionid', 100)->nullable(); //唯一ID
			$table->string('remark', 50)->nullable(); //备注
			$table->unsignedInteger('groupid')->nullable()->default(0); //组ID
			$table->unsignedInteger('subscribe_time')->nullable()->default(0); //关注时间
			$table->unsignedInteger('uid')->nullable()->default(0); //绑定的用户ID
			$table->timestamps();

			$table->foreign('waid')->references('id')->on('wechat_accounts');
			$table->unique(['waid', 'openid']);
		});
		Schema::create('wechat_articles', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('waid'); //account_id
			$table->unsignedInteger('wnid'); //新闻ID
			$table->timestamps();

			$table->foreign('waid')->references('id')->on('wechat_accounts');
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
