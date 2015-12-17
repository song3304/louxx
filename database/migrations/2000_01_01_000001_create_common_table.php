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
		Schema::create('sessions', function ($table) {
			$table->string('id', 190)->unique();
			$table->text('payload');
			$table->integer('last_activity');
		});

		Schema::create('fields', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 150)->index()->comment = '英文名称'; //英文名称
			$table->string('title', 150)->comment = '名称'; //名称
			$table->json('extra')->comment = '扩展数据'; //扩展
			$table->unsignedInteger('order_index')->default(0)->index()->comment = '排序序号'; //排序
			$table->string('field_class', 50)->index()->comment = '类别'; //类别
			$table->timestamps();
//			$table->softDeletes(); //软删除

			$table->unique(['name', 'field_class']);
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
