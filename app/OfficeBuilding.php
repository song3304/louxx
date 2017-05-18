<?php
namespace App;

use App\Model;

class OfficeBuilding extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];
    
	//物业
	public function property(){
	    return $this->hasOne('App\\Property','id','property_id');
	}
	
	//省
	public function province_name()
	{
	    return $this->hasOne('App\\Area', 'area_id', 'province');
	}
	//市
	public function city_name()
	{
	    return $this->hasOne('App\\Area', 'area_id', 'city');
	}
	//区
	public function area_name()
	{
	    return $this->hasOne('App\\Area', 'area_id', 'area');
	}
	//楼层
	public function floors()
	{
	    return $this->hasMany('App\\OfficeFloor', 'oid', 'id')->with(['company']);
	}
	//详情
	public function info()
	{
	    return $this->hasOne('App\\OfficeBuildingInfo', 'oid', 'id');
	}
	//招租
	public function hires()
	{
	    return $this->hasMany('App\\HireInfo', 'oid', 'id');
	}
	//周边
	public function peripheries()
	{
	    return $this->hasMany('App\\OfficePeripheries', 'oid', 'id');
	}
	//图片
	public function pics()
	{
	    return $this->hasMany('App\\OfficeBuildingPic', 'oid', 'id');
	}
	
	public function pic_ids()
	{
	    return $this->covers()->get(['pic_id'])->pluck('pic_id');
	}
	
	public function pic()
	{
	    return $this->covers()->first();
	}
	
	//标签
	public function tags()
	{
	    return $this->belongsToMany('App\\Tag', 'office_tag_relations', 'tid', 'oid');
	}
}
