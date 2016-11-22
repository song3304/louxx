<?php
namespace App;

use App\Model;

class Jobgable extends Model{
	
	protected $guarded = ['id'];
	protected $hidden = [];


	public function jobs()
	{
		return $this->hasMany('App\Job', 'id', 'job_id');
	}

}
