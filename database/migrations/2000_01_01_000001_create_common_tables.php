<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonTables extends Migration
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
			$table->string('name', 150); //名称
			$table->string('extra', 255); //扩展
			$table->unsignedInteger('order_index')->default(0)->index(); //排序
			$table->string('field_class', 50)->index(); //类别
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
