<?php
namespace App;

use App\Model;

class OfficeBuildingPic extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];

	public function building(){
	    return $this->hasOne('App\\OfficeBuilding','id','oid');
	}
}
