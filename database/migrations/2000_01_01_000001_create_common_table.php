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

		//日志
		Schema::create('logs', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('uid')->nullable()->default(0)->comment = '用户 ID';
			$table->bigInteger('ip')->default(0)->comment = 'IP';
			$table->string('agent', 250)->nullable()->comment = 'User Agent';
			$table->string('device', 50)->nullable()->comment = '设备';
			$table->string('event', 250)->nullable()->comment = '事件';
			$table->morphs('table');
			$table->timestamps();

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
		Schema::drop('sessions');
	}
}
