<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;
class Log extends Model
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

Log::creating(function($log){
	$request = app('request');
	$agent = new Agent();
	$log->ip = ip2long($request->getClientIp());
	$log->agent = $request->header('User-Agent');
	$log->device = $agent->isDesktop() ? $agent->platform() : $agent->device();
	
});