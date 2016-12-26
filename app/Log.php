<?php
namespace App;

use OwenIt\Auditing\Auditing;
use Jenssegers\Agent\Agent;
use Addons\Elasticsearch\Scout\Searchable;
use Addons\Core\Http\SerializableRequest;

class Log extends Auditing
{
	use Searchable;

	public $incrementing = true;
	protected $guarded = ['id'];

	protected $casts = [
		'request' => 'array',
		'old' => 'json',
		'new' => 'json',
	];
	

	public function table()
	{
		return $this->morphTo('auditable');
	}

	public function toSearchableArray()
	{
		$data = $this->toArray();
		return array_except($data, $this->appends);
	}

	public function scope_all(Builder $builder, $keywords)
	{
		if (empty($keywords)) return;
		$logs = static::search()->where(['ip', 'ua','browser', 'platform', 'device', 'type'], $keywords)->take(2000)->keys();
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
	if (!app()->runningInConsole())
	{
		$request = app('request');
		$agent = new Agent();
		$log->ip_address = $request->getClientIp();
		$log->ua = $request->header('User-Agent');
		$log->request = ((new SerializableRequest($request))->data());
		$log->method = $request->method();
		$log->browser = $agent->isRobot() ? $agent->robot() : $agent->browser().' '.$agent->version($agent->browser());
		$log->platform = $agent->platform().' '.$agent->version($agent->platform());
		$log->device = $agent->device();
	}
	
});