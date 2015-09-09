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
			$table->unsignedInteger('wechat_type')->default(0); //微信类型
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
			$table->enum('type', ['text','news','music','voice','image','video']); //素材类型
			$table->unsignedInteger('uid')->default(0); //用户ID
			$table->timestamps();

			$table->foreign('waid')->references('id')->on('wechat_accounts');
		});
		//微信素材-文章
		Schema::create('wechat_depot_news', function (Blueprint $table) {
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
		Schema::create('wechat_depot_news_relation', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('wdid'); //素材库
			$table->unsignedInteger('wdnid'); //文章ID
			$table->timestamps();

			$table->foreign('wdid')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('wdnid')->references('id')->on('wechat_news')
				->onUpdate('cascade')->onDelete('cascade');
			$table->unique(['wdid', 'wdnid']);
		});
		//微信素材-图片
		Schema::create('wechat_depot_images', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->unsignedInteger('aid'); //附件ID
			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
		});
		//微信素材-音频
		Schema::create('wechat_depot_voices', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->unsignedInteger('aid'); //附件ID
			$table->string('format', 20); //附件格式
			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
		});
		//微信素材-视频
		Schema::create('wechat_depot_videos', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->string('title', 250); //标题
			$table->string('description', 250); //摘要
			$table->unsignedInteger('aid'); //附件ID
			$table->unsignedInteger('thunm_aid'); //缩略图附件ID
			$table->string('format', 20); //附件格式
			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
		});
		//微信素材-音乐
		Schema::create('wechat_depot_musics', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->unsignedInteger('aid'); //附件ID
			$table->string('format', 20); //附件ID
			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
		});
		//微信素材-文字
		Schema::create('wechat_depot_texts', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->text('content'); //文字内容
			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
		});

		//微信菜单
		Schema::create('wechat_menus', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('waid')->index(); //account id
			$table->unsignedInteger('pid')->default(0)->index(); //pid
			$table->string('title', 50); //标题
			$table->string('type', 50); //类型
			$table->string('event', 50)->nullable(); //事件名称
			$table->string('event_key', 150)->nullable(); //事件参数
			$table->string('url', 250)->nullable(); //网址
			$table->unsignedInteger('wdid')->default(0); //网址
			$table->string('callback', 250)->nullable(); //函数回调名称
			
			//tree
			$this->unsignedInteger('order')->default(0)->index();
			$this->unsignedInteger('level')->default(0)->index();
			$this->string('path', '250')->index();

			$table->timestamps();

			$table->foreign('waid')->references('id')->on('wechat_accounts')
				->onUpdate('cascade')->onDelete('cascade');
		});

		//微信消息
		Schema::create('wechat_messages', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('waid')->index(); //account id
			$table->unsignedInteger('wuid')->index(); //user id
			$table->enum('transport_type', ['send', 'receive'])->index(); //是发送还是接受
			$table->enum('type', ['depot', 'text', 'image', 'video', 'voice', 'link', 'location']); //类型
			$table->tinyInteger('status'); //状态
			$table->timestamps();
			$table->softDeletes(); //软删除

			$table->foreign('waid')->references('id')->on('wechat_accounts')
				->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('wuid')->references('id')->on('wechat_users')
				->onUpdate('cascade')->onDelete('cascade');
		});

		//微信消息-素材-关联表
		Schema::create('wechat_message_depots', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique(); 
			$table->unsignedInteger('wdid')->index(); //素材ID

			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_messages')
				->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('wdid')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
		});

		//微信消息-图片
		Schema::create('wechat_message_pictures', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->string('url', 250); // 原始图片网址
			$table->unsignedInteger('aid'); //附件ID
			$table->string('media_id', 250); //微信Media ID

			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_messages')
				->onUpdate('cascade')->onDelete('cascade');
		});

		//微信消息-Link
		Schema::create('wechat_message_links', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->string('title', 100)->nullable(); //标题
			$table->string('description', 250)->nullable(); //摘要
			$table->string('url', 250); //网址
			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_messages')
				->onUpdate('cascade')->onDelete('cascade');
		});

		//微信消息-Link
		Schema::create('wechat_message_locations', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->decimal('x', 20, 6)->default(0);
			$table->decimal('y', 20, 6)->default(0);
			$table->smallInteger('scale');
			$table->string('precision', 100);
			$table->string('label', 250);
			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_messages')
				->onUpdate('cascade')->onDelete('cascade');
		});

		//微信消息-图片/视频/音频
		Schema::create('wechat_message_media', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->string('format', 50); //文件格式
			$table->string('media_id', 250); //微信Media ID
			$table->string('thumb_media_id', 250); //缩略图Media ID

			$table->unsignedInteger('aid');
			$table->unsignedInteger('thumb_aid');

			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_messages')
				->onUpdate('cascade')->onDelete('cascade');
		});

		//微信消息-Link
		Schema::create('wechat_message_texts', function (Blueprint $table) {
			$table->unsignedInteger('id')->unique();
			$table->text('content'); //内容

			$table->timestamps();

			$table->foreign('id')->references('id')->on('wechat_messages')
				->onUpdate('cascade')->onDelete('cascade');
		});


		//微信自定义回复触发条件
		Schema::create('wechat_replies', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('waid')->index(); //account id
			$table->enum('match_type', ['subscribe', 'whole', 'part']);
			$table->string('keywords', 100)->nullable()->index();
			$table->enum('reply_type', ['all', 'random'])->index();

			$table->timestamps();

			$table->foreign('wdid')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
		});

		//微信自定义回复
		Schema::create('wechat_reply_contents', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('waid')->index(); //account id
			$table->unsignedInteger('wdid')->index(); //素材ID
			$table->timestamps();

			$table->foreign('wdid')->references('id')->on('wechat_depots')
				->onUpdate('cascade')->onDelete('cascade');
		});

		//微信自定义回复触发条件-回复内容关联表
		Schema::create('wechat_reply_relation', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('wrid')->index(); //
			$table->unsignedInteger('wrcid')->index(); //account id

			$table->timestamps();

			$table->foreign('wrid')->references('id')->on('wechat_replies')
				->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('wrcid')->references('id')->on('wechat_reply_contents')
				->onUpdate('cascade')->onDelete('cascade');
			$table->unique(['wrid', 'wrcid']);
		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('');
	}
}
