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
		//微信账号库
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
		//微信用户库
		Schema::create('wechat_users', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('waid'); //account_id
			$table->string('openid', 150)->index(); //OpenID
			$table->string('nickname', 50)->nullable(); //昵称
			$table->unsignedInteger('gender')->nullable()->default(0); //性别
			$table->unsignedInteger('avatar_aid')->nullable()->default(0); //头像
			$table->tinyInteger('is_subscribe')->default(0); //是否关注
			$table->string('country',50)->nullable(); //国家
			$table->string('province',50)->nullable(); //省
			$table->string('city',50)->nullable(); //市
			$table->string('language',20)->nullable(); //语言
			$table->string('unionid', 150)->nullable(); //唯一ID
			$table->string('remark', 50)->nullable(); //备注
			$table->unsignedInteger('groupid')->nullable()->default(0); //组ID
			$table->unsignedInteger('subscribe_time')->nullable()->default(0); //关注时间
			$table->unsignedInteger('uid')->nullable()->default(0); //绑定的用户ID
			$table->timestamps();

			$table->foreign('waid')->references('id')->on('wechat_accounts');
			$table->unique(['waid', 'openid']);
		});
		//微信素材库
		Schema::create('wechat_depots', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('waid'); //account_id
			$table->enum('type', ['text','articles','audio','picture','video']); //素材类型
			$table->unsignedInteger('uid')->default(0); //用户ID
			$table->timestamps();

			$table->foreign('waid')->references('id')->on('wechat_accounts');
		});
		//微信素材-文章
		Schema::create('wechat_articles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title', 250); //标题
			$table->string('author', 100); //作者
			$table->string('description', 250); //简介
			$table->unsignedInteger('cover_aid')->default(0); //封面图片
			$table->tinyInteger('cover_in_content')->default(0); //是否将封面插入正文中
			$table->text('content'); //内容
			$table->string('link', 250); //内容
			$table->timestamps();
		});
		//微信素材库关联表
		Schema::create('wechat_depot_article', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('wdid'); //素材库
			$table->unsignedInteger('waid'); //文章ID
			$table->timestamps();

			$table->foreign('wdid')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('waid')->references('id')->on('wechat_articles')
				->onUpdate('cascade')->onDelete('cascade');
			$table->unique(['wdid', 'waid']);
		});
		//微信素材-图片/视频/音频
		Schema::create('wechat_media', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('wdid'); //depot id
			$table->string('title', 250); //标题
			$table->string('description', 250); //简介
			$table->unsignedInteger('file_aid'); //附件ID
			$table->timestamps();

			$table->foreign('wdid')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
		});
		//微信素材-文字
		Schema::create('wechat_texts', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('wdid'); //depot id
			$table->text('content'); //文字内容
			$table->timestamps();

			$table->foreign('wdid')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
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
