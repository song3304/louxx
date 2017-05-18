<?php
namespace App;

use App\Model;

class FloorCompanyRelation extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];

	public function floor(){
	    return $this->hasOne('App\\OfficeFloor','id','oid');
	}
	
	public function company(){
	    return $this->hasOne('App\\Company','id','cid');
	}
}
