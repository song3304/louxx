<?php
namespace App;

use App\Model;

class HirePic extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];

	public function hire(){
	    return $this->hasOne('App\\HireInfo','id','hid');
	}
}
