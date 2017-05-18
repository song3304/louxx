<?php
namespace App;

use App\Model;

class HireInfo extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];
	
	//办公楼
	public function building(){
	    return $this->hasOne('App\\OfficeBuilding','id','oid');
	}
	//楼层
	public function floor(){
	    return $this->hasOne('App\\OfficeFloor','id','fid');
	}
	//状态
	public function status_tag(){
	    $tag = '';
	    switch ($this->status){
	        case 0:
	            $tag="招租中";break;
	        case 1:
	            $tag="已租";break;
	        case -1:
	            $tag="已废弃";break;
	    }
	    return $tag;
	}
}
