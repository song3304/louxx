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
			$table->string('basename', 255)->index()->comment = '存储的文件名'; //本地文件名
			$table->string('path', 255)->comment = '存储文件路径'; //本地文件名
			$table->string('hash', 50)->index()->comment = '文件MD5'; //文件的MD5
			$table->unsignedInteger('size')->index()->comment = '文件大小'; //文件大小
			$table->timestamps();
			$table->unique(['hash','size']);
			$table->softDeletes(); //软删除
		});

		Schema::create('attachments', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('afid')->default(0)->comment = 'AttachmentFile ID'; //文件ID
			$table->string('filename', 255)->comment = '原始文件名(无后缀)'; //显示的文件名
			$table->string('ext', 50)->index()->comment = '文件扩展名'; //显示的扩展名
			$table->string('original_basename', 255)->comment = '原始文件名'; //原始名称
			$table->text('description')->nullable()->comment = '摘要'; //摘要
			$table->unsignedInteger('uid')->nullable()->default(0)->comment = '用户ID'; //用户id

			$table->timestamps(); //创建/修改时间
			$table->foreign('afid')->references('id')->on('attachment_files')->onDelete('cascade');
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
