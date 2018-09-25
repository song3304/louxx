<?php
namespace App;

use App\Model;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Tag;

class OfficeBuilding extends Model{
	// use SoftDeletes;
	
	protected $guarded = ['id'];
	protected $hidden = [];
	protected $appends = ['full_address'];
	
	public function full_address($format = '%P%C%D %A')
	{
	    $data = [
	        '%P' => $this->province_name->area_name,
	        '%C' => $this->city_name->area_name,
	        '%D' => $this->area_name->area_name,
	        '%A' => $this->address,
	    ];
	    return strtr($format, $data);
	}
	
	public function getFullAddressAttribute()
	{
	    return $this->full_address();
	}
	
	//物业
	public function properter(){
	    return $this->hasOne('App\\Properter','id','property_id');
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
	    return $this->hasMany('App\\OfficeFloor', 'oid', 'id')->with(['companies']);
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
	    return $this->hasMany('App\\OfficePeriphery', 'oid', 'id');
	}
	//图片
	public function pics()
	{
	    return $this->hasMany('App\\OfficeBuildingPic', 'oid', 'id');
	}
	
	public function pic_ids()
	{
	    return $this->pics()->get(['pic_id'])->pluck('pic_id');
	}
	
	public function pic()
	{
	    return $this->pics()->first();
	}
	
	//标签
	public function tags()
	{
	    return $this->belongsToMany('App\\Tag', 'office_tag_relations', 'oid', 'tid');
	}
	
	public function tag_ids()
	{
	    return $this->tags()->get()->pluck('id');
	}
	
	public function scopeProperty(Builder $builder, $property_user_id)
	{
	    $builder->where('property_id', $property_user_id);
	}
	
	public function scopeOfTag(Builder $builder, $tag_id)
	{
	    $builder->join('office_tag_relations', 'office_tag_relations.oid', '=', 'office_buildings.id', 'LEFT');
	    $builder->where('office_tag_relations.tid', $tag_id)->select('office_buildings.*');
	}
	
	public function scopeOfPrice(Builder $builder, $prices)
	{
	    $builder->join('hire_infos', 'hire_infos.oid', '=', 'office_buildings.id','LEFT');
	    if(!is_array($prices)){
	        $prices = [intval($prices),intval($prices)+1];
	    }
	    $builder->whereBetween('hire_infos.per_rent',$prices);
	}
}
