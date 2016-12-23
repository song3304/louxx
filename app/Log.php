<?php
namespace App;

use App\Model;
use Jenssegers\Agent\Agent;
use App\IpCastTrait;
class Log extends Model
{
	use IpCastTrait;
    protected $guarded = ['id'];
	protected $hidden = [];
	protected $casts = [
		'ip' => 'ip',
	];

	public function user()
	{
		return $this->hasOne('App\\User', 'id', 'uid');
	}

	public function table()
	{
		return $this->morphTo();
	}

	public function scope_all(Builder $builder, $keywords)
	{
		if (empty($keywords)) return;
		$logs = static::search()->where(['ip', 'agent', 'device', 'event'], $keywords)->take(2000)->keys();
		return $builder->whereIn($this->getKeyName(), $logs);
	}

	public function scopeOfIp(Builder $builder, $ip)
	{
		if (empty($ip)) return;
		$logs = static::search()->where('ip', $ip)->take(2000)->keys();
		return $builder->whereIn($this->getKeyName(), $logs);
	}
}

Log::creating(function($log){
	$request = app('request');
	$agent = new Agent();
	$log->ip = $request->getClientIp();
	$log->agent = $request->header('User-Agent');
	$log->device = $agent->isDesktop() ? $agent->platform() : $agent->device();
	
});