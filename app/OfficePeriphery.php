<?php
namespace App;

use App\Model;
//周边
class OfficePeriphery extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];
	
	//办公楼
	public function building(){
	    return $this->hasOne('App\\OfficeBuilding','id','oid');
	}
	//建筑类型
	public function type_tag(){
	    $tag = '';
	    switch ($this->type){
	        case 0:
	            $tag="餐厅";break;
	        case 1:
	            $tag="酒店";break;
	        case 2:
	            $tag="健身";break;
	        case 3:
	            $tag="银行";break;
	    }
	    return $tag;
	}
}
