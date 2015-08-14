<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attachment_files', function (Blueprint $table) {
			$table->increments('id');
			$table->string('basename', 255)->index(); //本地文件名
			$table->string('path', 255); //本地文件名
			$table->string('hash', 50)->index(); //文件的MD5
			$table->unsignedInteger('size')->index(); //文件大小
			$table->timestamps();
			$table->unique(['hash','size']);
			$table->softDeletes(); //软删除
		});

		Schema::create('attachments', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('afid')->default(0); //用户id
			$table->string('filename', 255); //显示的文件名
			$table->string('ext', 50)->index(); //显示的扩展名
			$table->string('original_basename', 255); //原始名称
			$table->text('description')->nullable(); //真实姓名
			$table->unsignedInteger('uid')->nullable(); //用户id

			$table->timestamps(); //创建/修改时间

			$table->foreign('afid')->references('id')->on('attachment_files')->onDelete('cascade');
			$table->foreign('uid')->references('id')->on('users')/*->onDelete('cascade')*/;

		});

		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attachment_files');
		Schema::drop('attachments');
	}
}
