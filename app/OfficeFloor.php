<?php
namespace App;

use App\Model;
use Illuminate\Database\Eloquent\Builder;

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
