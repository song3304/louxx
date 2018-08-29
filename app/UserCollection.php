<?php
namespace App;

use App\Model;
use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Tag;

class UserCollection extends Model{
	// use SoftDeletes;
	
	protected $guarded = ['id'];
	protected $hidden = [];
	
	//用户
	public function user(){
	    return $this->hasOne('App\\User','id','uid');
	}
    //办公楼
    public function office(){
        return $this->hasOne('App\\OfficeBuilding','id','oid');
    }
}
