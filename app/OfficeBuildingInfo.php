<?php
namespace App;

use App\Model;

class OfficeBuildingInfo extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];
	
	
	//办公楼
	public function building(){
	    return $this->hasOne('App\\OfficeBuilding','id','oid');
	}
	//业主状态
	public function owner_tag(){
	    $tag = '';
	    switch ($this->owner_type){
	        case 0:
	            $tag="大业主+小业主";break;
	        case 1:
	            $tag="大业主";break;
	        case 2:
	            $tag="小业主";break;
	    }
	    return $tag;
	}
	//状态
	public function level_tag(){
	    $tag = '';
	    switch ($this->level){
	        case 0:
	            $tag="未知";break;
	        case 1:
	            $tag="甲级";break;
	        case 2:
	            $tag="乙级";break;
	        case 3:
	           $tag="丙级";break;
	    }
	    return $tag;
	}
}
