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
	//标签
	public function tags()
	{
	    return $this->belongsToMany('App\\Tag', 'floor_tag_relations', 'fid', 'tid');
	}
	//公司
	public function companies()
	{
	    return $this->belongsToMany('App\\Company', 'floor_company_relations','fid' , 'cid');
	}
	//选择标签
	public function scopeOfTag(Builder $builder, $tag_id)
	{
	    $builder->join('floor_tag_relations', 'floor_tag_relations.fid', '=', 'office_floors.id', 'LEFT');
	    $builder->where('floor_tag_relations.tid', $tag_id)->select('office_floors.*');
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
