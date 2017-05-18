<?php
namespace App;

use App\Model;

class PropertyApply extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];

	public function user(){
	    return $this->hasOne('App\\User','id','uid');
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
}
