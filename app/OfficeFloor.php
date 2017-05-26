<?php
namespace App;

use App\Model;

class OfficeFloor extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];
    
	//办公楼
	public function building(){
	    return $this->hasOne('App\\OfficeBuilding','id','oid');
	}
	
	//公司
	public function companies()
	{
	    return $this->belongsToMany('App\\Company', 'floor_company_relations','fid' , 'cid');
	}
}
