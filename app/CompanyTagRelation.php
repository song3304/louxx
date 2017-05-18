<?php
namespace App;

use App\Model;

class CompanyCompanyRelation extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];

    public function tag(){
	    return $this->hasOne('App\\Tag','id','tid');
	}
	
	public function company(){
	    return $this->hasOne('App\\Company','id','cid');
	}
}
