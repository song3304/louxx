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
			$table->string('id', 190)->unique();
			$table->text('payload');
			$table->integer('last_activity');
		});

		Schema::create('fields', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 150)->index()->comment = '英文名称'; //英文名称
			$table->string('title', 150)->comment = '名称'; //名称
			$table->json('extra')->comment = '扩展数据'; //扩展
			$table->unsignedInteger('pid')->default(0)->index()->_comment = '父ID'; //父ID
			$table->unsignedInteger('order_index')->default(0)->index()->comment = '排序序号'; //排序
			$table->string('field_class', 50)->index()->comment = '类别'; //类别
			$table->timestamps();
//			$table->softDeletes(); //软删除

			$table->unique(['name', 'field_class']);
		});
		
		Schema::create('fields_content', function(Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('fid')->default(0)->index()->_comment = 'fields id'; //
			$table->text('content')->nullable()->_comment = '内容'; 
			$table->timestamps();

			$table->foreign('fid')->references('id')->on('fields')->onDelete('cascade');

		});
		
		 Schema::create('tags', function (Blueprint $table) {
	            $table->increments('id');
	            $table->string('keywords', 100)->index()->_comment = "关键词";
	            $table->timestamps();

	        });

	        //评价
        Schema::create('taggables', function (Blueprint $table) {
            $table->increments('id');

            $table->string('taggable_type', 100)->_comment = "指向表名";
            $table->unsignedInteger('taggable_id')->_comment = 'table column ID';
            $table->unsignedInteger('tag_id')->index()->_comment = 'tags ID';

			$table->foreign('tag_id')->references('id')->on('tags')->onUpdate('cascade')->onDelete('cascade');
		});

		//点击
		Schema::create('hits', function (Blueprint $table) {
			$table->increments('id');

			$table->unsignedInteger('uid')->nullable()->default(0)->_comment = '用户 ID';
			$table->bigInteger('ip')->default(0)->_comment = 'IP';
			$table->string('agent', 250)->nullable()->_comment = 'User Agent';
			$table->string('table_type', 125)->index()->_comment = "多态关联TYPE";
			$table->unsignedInteger('table_id')->index()->_comment = '多态关联ID';
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
