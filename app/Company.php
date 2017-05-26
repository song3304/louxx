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
	    return $this->belongsToMany('App\\OfficeFloor', 'floor_company_relations', 'cid', 'fid');
	}
	
	//公司
	public function tags()
	{
	    return $this->belongsToMany('App\\Tag', 'company_tag_relations', 'cid', 'tid');
	}
	//规模
	public function people_scale()
	{
	    $scale_tag = '';
	    switch ($this->people_cnt){
	        case 0:$scale_tag='1-10人';break;
	        case 1:$scale_tag='10-50人'; break;
	        case 2:$scale_tag='50-100人'; break;
	        case 3:$scale_tag='100-500人'; break;
	        case 4:$scale_tag='500-1000人'; break;
	        case 5:$scale_tag='1000人以上'; break;
	        default: $scale_tag='未知';
	    }
	    return $scale_tag;
	}
}
