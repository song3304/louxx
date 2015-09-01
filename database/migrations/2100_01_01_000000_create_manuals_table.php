<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManualsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manuals', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedInteger('pid')->default(0)->index();
			$table->string('title', '250');
			$table->text('content')->nullable();
			$table->integer('order')->default(0)->index();
			$table->unsignedInteger('level')->default(0)->index();
			$table->string('path', 250)->index();
			$table->timestamps();
		});
		Schema::create('manual_histories', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('mid')->index();
			$table->string('title', '250');
			$table->text('content')->nullable();
			//$table->unsignedInteger('uid')->default(0);
			$table->timestamps();
			$table->foreign('mid')->references('id')->on('manuals');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('jobs');
		Schema::drop('failed_jobs');
	}
}
