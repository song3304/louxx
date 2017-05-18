<?php
namespace App;

use App\Model;

class Company extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];
    
	//办公楼
	public function building(){
	    return $this->hasOne('App\\OfficeBuilding','id','oid');
	}
	
	//楼层-可能多层
	public function floors()
	{
	    return $this->belongsToMany('App\\OfficeFloor', 'floor_company_relations', 'fid', 'cid');
	}
	
	//公司
	public function tags()
	{
	    return $this->belongsToMany('App\\Tag', 'company_tag_relations', 'tid', 'cid');
	}
}
