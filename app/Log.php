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
		$data = array_except($data, $this->appends);
		!empty($data['new']) && $data['new'] = json_encode($data['new']);
		!empty($data['old']) && $data['old'] = json_encode($data['old']);

		$data['request']['server'] = array_only($data['request']['server'], ['HTTP_HOST', 'HTTP_SCHEME', 'HTTPS', 'HTTP_CONNECTION', 'CONTENT_LENGTH', 'HTTP_ORIGIN', 'HTTP_X_CSRF_TOKEN', 'CONTENT_TYPE', 'HTTP_ACCEPT', 'HTTP_X_REQUESTED_WITH', 'HTTP_REFERER', 'HTTP_ACCEPT_ENCODING', 'HTTP_ACCEPT_LANGUAGE', 'HTTP_COOKIE', 'SERVER_SIGNATURE', 'SERVER_SOFTWARE', 'SERVER_NAME', 'SERVER_ADDR', 'SERVER_PORT', 'REMOTE_ADDR', 'DOCUMENT_ROOT', 'REQUEST_SCHEME', 'CONTEXT_PREFIX', 'CONTEXT_DOCUMENT_ROOT', 'SCRIPT_FILENAME', 'REMOTE_PORT', 'REDIRECT_URL', 'GATEWAY_INTERFACE', 'SERVER_PROTOCOL', 'REQUEST_METHOD', 'QUERY_STRING', 'REQUEST_URI', 'SCRIPT_NAME', 'PHP_SELF', 'REQUEST_TIME_FLOAT', 'REQUEST_TIME', 'FCGI_ROLE', 'REDIRECT_STATUS']);
		foreach($data['request'] as $k => &$v)
			$k !== 'server' && $v = json_encode($v);
		return $data;
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