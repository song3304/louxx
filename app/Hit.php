<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hit extends Model
{
    protected $guarded = ['id'];
	protected $hidden = [];

	public function user()
	{
		return $this->hasOne('App\\User', 'id', 'uid');
	}

	public function table()
	{
		return $this->morphTo();
	}
}

Hit::creating(function($hit){
	$request = app('request');
	$hit->ip = $request->getClientIp();
	$hit->agent = $request->header('User-Agent');
});