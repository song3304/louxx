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
		Schema::create('fields', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 150)->index(); //英文名称
			$table->string('title', 150); //名称
			$table->json('extra'); //扩展
			$table->unsignedInteger('order_index')->default(0)->index(); //排序
			$table->string('field_class', 50)->index(); //类别
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
	}
}
