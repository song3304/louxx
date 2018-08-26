<?php
namespace App;

use App\Model;
use Illuminate\Database\Eloquent\Builder;

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
	//图片
	public function pics()
	{
	    return $this->hasMany('App\\HirePic', 'hid', 'id');
	}
	
	public function pic_ids()
	{
	    return $this->pics()->get(['pic_id'])->pluck('pic_id');
	}
	
	public function pic()
	{
	    return $this->pics()->first();
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
	//筛选办公楼
	public function scopeBuildings(Builder $builder, $building_ids)
	{
	    if(is_array($building_ids)){
	        $builder->whereIn('oid',$building_ids);
	    }else{
	        $builder->where('oid', intval($building_ids));
	    }
	}
}
