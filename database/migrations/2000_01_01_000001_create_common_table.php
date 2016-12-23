<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sessions', function (Blueprint $table) {
			$table->string('id', 190)->unique()->primary();
			$table->text('payload');
			$table->integer('last_activity');
		});

		Schema::create('catalogs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 150)->index()->comment = '英文名称';
			$table->string('title', 150)->comment = '名称';
			$table->string('description', 250)->nullable()->comment = '';
			$table->text('extra')->nullable()->comment = '扩展数据';
			$table->unsignedInteger('pid')->default(0)->comment = '父ID';
			$table->unsignedInteger('order_index')->default(0)->index()->comment = '排序序号';
			$table->timestamps();
			$table->softDeletes();

			$table->unique(['pid', 'name']);
		});
		
		Schema::create('tags', function (Blueprint $table) {
			$table->increments('id');
			$table->string('keywords', 100)->index()->comment = "关键词";
			$table->timestamps();
		});

		//Tag多态关联表
		Schema::create('taggables', function (Blueprint $table) {
			$table->increments('id');
			$table->morphs('taggable');
			$table->unsignedInteger('tag_id')->index()->comment = 'tags ID';

			$table->foreign('tag_id')->references('id')->on('tags')->onUpdate('cascade')->onDelete('cascade');
		});

		Schema::create('logs', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('type')->inex()->comment = '事件';
			$table->morphs('auditable');
			$table->text('old')->nullable()->comment = '舊數據';
			$table->text('new')->nullable()->comment = '新數據';
			$table->unsignedInteger('user_id')->nullable()->default(0)->comment = '用戶 ID';
			$table->string('method', 50)->nullable()->comment = '請求方法';
			$table->string('route')->nullable()->comment = '網址';
			$table->longText('request')->nullable()->comment = '序列化后的Request';
			$table->string('ua', 250)->nullable()->comment = 'User Agent';
			$table->string('browser', 50)->nullable()->comment = '瀏覽器';
			$table->string('platform', 50)->nullable()->comment = '平臺';
			$table->string('device', 50)->nullable()->comment = '設備';
			$table->ipAddress('ip_address', 45)->nullable()->comment = 'IP';
			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('logs');
		Schema::drop('fields');
		Schema::drop('sessions');
	}
}
