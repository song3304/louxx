<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLouxxTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		//物业申请
		Schema::create('properter_applies', function (Blueprint $table) {
			$table->integer('id', true);
			$table->string('name', 150)->unique()->comment = '物业名';
			$table->integer('province')->nullable()->comment = '省';
			$table->integer('city')->nullable()->comment = '市';
			$table->integer('area')->nullable()->comment = '区';
			$table->string('address',250)->default(0)->comment = '详情地址';
			$table->string('phone', 20)->nullable()->index()->comment = '电话'; 
			$table->string('note', 250)->nullable()->comment = '备注';
			$table->tinyInteger('status')->default(0)->index()->comment = '0.未审核 1.审核通过 2.审核不过';
			$table->string('audit_note', 250)->nullable()->comment = '审核备注';
			$table->unsignedInteger('uid')->default(0)->comment='用户id,通过后会绑定一个用户';
			
			$table->softDeletes(); //软删除
			$table->timestamps();
		});

		
		//物业人员
		Schema::create('properters', function (Blueprint $table) {
		    $table->unsignedInteger('id')->index()->comment = '物业人员id';
		    $table->string('name',250)->comment='物业名称';
		    $table->unsignedInteger('province')->comment = '省'; //省
		    $table->unsignedInteger('city')->comment = '市'; //市
		    $table->unsignedInteger('area')->comment = '区'; //区县
		    $table->string('address', 250)->comment = '地址';
		    $table->string('phone', 20)->nullable()->index()->comment = '电话'; //电话
		    $table->softDeletes(); //软删除
		         
		    $table->foreign('id')->references('id')->on('users')
		    ->onUpdate('cascade')->onDelete('cascade');
		    $table->timestamps();
		 });
		    
		//办公楼
		Schema::create('office_buildings', function (Blueprint $table) {
			$table->increments('id')->comment='主键';
			$table->integer('province')->nullable()->comment = '省';
			$table->integer('city')->nullable()->comment = '市';
			$table->integer('area')->nullable()->comment = '区';
			$table->string('village_name',250)->nullable()->comment = '小区名';
			$table->string('building_name',250)->nullable()->comment = '办公楼名';
			$table->string('address')->default(0)->comment = '详情地址';
			$table->decimal('longitude', 16, 10)->comment='经度'; //经度
			$table->decimal('latitude', 16, 10)->comment='纬度'; //纬度
			$table->integer('property_id')->unsigned()->index()->comment = '所属物业';
			$table->timestamps();
			
			$table->softDeletes(); //软删除
			$table->foreign('id')->references('id')->on('users')
				->onUpdate('cascade')->onDelete('cascade');
		});
		//办公楼图片
		Schema::create('office_building_pics', function (Blueprint $table) {
		    $table->increments('id')->comment='主键';
		    $table->unsignedInteger('oid')->default(0)->comment='办公楼id'; 
		    $table->unsignedInteger('pic_id')->default(0)->comment='图片id'; 
		    $table->timestamps();
		    
		    $table->foreign('oid')->references('id')->on('office_buildings')
		    ->onUpdate('cascade')->onDelete('cascade');
		});
		//标签处理
		Schema::create('tags', function (Blueprint $table) {
		    $table->increments('id')->comment='主键';
		    $table->string('tag_name',20)->nullable()->comment = '标签名';
		    $table->tinyInteger('type')->default(0)->comment = '类型:0.办公楼 1.公司 ';
		    
		    $table->softDeletes(); //软删除
		    $table->timestamps();
		});
		//办公楼与标签对应关系表 多对多
		Schema::create('office_tag_relations', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('oid')->unsigned()->index()->comment = '办公楼ID';
		    $table->integer('tid')->unsigned()->index()->comment = '标签ID';
		    $table->integer('porder')->default(0)->unsigned()->index()->comment = '排序';
		    $table->timestamps();
		});
		//楼层表
		Schema::create('office_floors', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('oid')->default(0)->comment='办公楼id';
			$table->string('name',150)->unique()->comment = '楼层名';
			$table->string('description')->nullable()->comment = '层名介绍';
			$table->integer('porder')->default(0)->unsigned()->index()->comment = '排序';
			
			$table->softDeletes(); //软删除
			$table->timestamps();
			
			$table->foreign('oid')->references('id')->on('office_buildings')
			->onUpdate('cascade')->onDelete('cascade');
		});

		//公司，部分信息
		Schema::create('companies', function (Blueprint $table) {
		    $table->increments('id');
		    $table->unsignedInteger('oid')->default(0)->comment='办公楼id';
			$table->string('name',50)->comment = '公司名';
			$table->unsignedInteger('logo_id')->default(0)->comment='公司logo';
			$table->tinyInteger('people_cnt')->default(0)->comment = '公司人员:0.1-10人 1.10-50人 2.50-100人 3 100-500人 4.500-1000人 6 1000人以上 ';
			$table->string('description')->nullable()->comment = '公司介绍';//招聘,查询

			$table->softDeletes(); //软删除
			$table->timestamps();
		});

		//公司与楼层关系
		Schema::create('floor_company_relations', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('fid')->unsigned()->index()->comment = '楼层ID';
		    $table->integer('cid')->unsigned()->index()->comment = '公司ID';
		    $table->integer('porder')->default(0)->unsigned()->index()->comment = '排序';
		    $table->timestamps();
		});
		
	   //公司与标签关系
	   Schema::create('company_tag_relations', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('cid')->unsigned()->index()->comment = '公司ID';
		    $table->integer('tid')->unsigned()->index()->comment = '标签ID';
		    $table->integer('porder')->default(0)->unsigned()->index()->comment = '排序';
		    $table->timestamps();
		});
		//文章资讯
		Schema::create('articles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title',100)->nullable()->comment = '资讯标题';
			$table->text('content')->nullable()->comment = '内容';

			$table->softDeletes(); //软删除
			$table->timestamps();
		});
        //招租信息发布
		Schema::create('hire_infos', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('oid')->unsigned()->index()->comment = '办公楼id';
		    $table->integer('fid')->unsigned()->index()->comment = '楼层id';
		    $table->decimal('rent',10,2)->default(0)->index()->comment = '租金(元/月)';
		    $table->decimal('per_rent',10,2)->default(0)->index()->comment = '每平方租金(元/天)';
		    $table->integer('acreage')->unsigned()->default(0)->index()->comment = '面积';
		    $table->integer('min_station_cnt')->unsigned()->default(0)->index()->comment = '最小工位数';
		    $table->integer('max_station_cnt')->unsigned()->default(0)->index()->comment = '最大工位数';
		    $table->tinyInteger('status')->default(0)->index()->comment = '0.招租中 1.已租 -1.已废弃';
		    $table->string('note')->nullable()->comment = '备注保留字段';
		    $table->softDeletes(); //软删除
		    $table->timestamps();
		    
		    $table->foreign('fid')->references('id')->on('office_floors')
		    ->onUpdate('cascade')->onDelete('cascade');
		});
		//楼盘详情介绍
		Schema::create('office_building_infos', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('oid')->unsigned()->index()->comment = '办公楼id';
		    $table->integer('occupancy_rate')->unsigned()->index()->comment = '得房率 0-100';
		    $table->tinyInteger('owner_type')->default(0)->index()->comment = '业主类型 0.大业主+小业主';
		    $table->integer('floor_cnt')->default(0)->index()->comment = '楼层数';
		    $table->tinyInteger('level')->default(0)->index()->comment = '物业类型 0 未知 1.甲级 2.乙级  3.丙级';
		    $table->decimal('floor_height',5,2)->default(0)->index()->comment = '每层净高(m)';
		    $table->decimal('property_price',5,2)->default(0)->index()->comment = '物业费(平方/月)';
		    $table->string('property_type',20)->nullable()->comment = '物业类型';
		    $table->string('developer',20)->nullable()->comment = '开发商';
		    $table->decimal('avg_price',5,2)->default(0)->comment = '均价 元/平方 天';
		    $table->integer('parking_space_cnt')->default(0)->index()->comment = '停车位';
		    $table->decimal('parking_price',5,2)->default(0)->comment = '停车费 元/月';
		    $table->timestamp('publish_time')->nullable()->comment = '竣工时间';
		    $table->string('area_covered',20)->nullable()->comment = '占地面积';
		    $table->string('standard_area',20)->nullable()->comment = '标准层面积';
		    $table->integer('upstairs_cnt')->default(0)->comment = '楼上层数';
		    $table->integer('downstairs_cnt')->default(0)->comment = '楼下层数';
		    $table->string('plot_ratio',20)->nullable()->comment = '容积率';
		    $table->string('green_ratio',20)->nullable()->comment = '绿化率';
		   
		    $table->softDeletes(); //软删除
		    $table->timestamps();
		    
		    $table->foreign('oid')->references('id')->on('office_buildings')
		        ->onUpdate('cascade')->onDelete('cascade');
		});
		
		//楼盘周边配套
		Schema::create('office_peripheries', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('oid')->unsigned()->index()->comment = '办公楼id';
		    $table->tinyInteger('type')->default(0)->index()->comment = '类型 0.餐厅 1.酒店 2.健身 2.银行';
		    $table->string('name',20)->nullable()->comment = '名字';
		    $table->decimal('longitude', 16, 10)->comment='经度'; //经度
		    $table->decimal('latitude', 16, 10)->comment='纬度'; //纬度
		    
		    $table->softDeletes(); //软删除
		    $table->timestamps();
		    
		    $table->foreign('oid')->references('id')->on('office_buildings')
		    ->onUpdate('cascade')->onDelete('cascade');
		 });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
		Schema::drop('property_applies');
		Schema::drop('properters');
		Schema::drop('office_buildings');
		Schema::drop('office_building_pics');
		Schema::drop('tags');
		Schema::drop('office_tag_relations');
		Schema::drop('office_floors');
		Schema::drop('companies');
		Schema::drop('floor_company_relations');
		Schema::drop('company_tag_relations');
		Schema::drop('articles');
		Schema::drop('hire_infos');
		Schema::drop('office_building_infos');
		Schema::drop('office_peripheries');
	}
}
