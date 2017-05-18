<?php
namespace App;

use App\Model;

class OfficeTagRelation extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];

	public function building(){
	    return $this->hasOne('App\\OfficeBuilding','id','oid');
	}
	
	public function tag(){
	    return $this->hasOne('App\\Tag','id','tid');
	}
}
