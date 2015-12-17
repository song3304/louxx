<?php

namespace App\Http\Middleware;

use Addons\Core\Middleware\Core as BaseCore;

class Core extends BaseCore
{
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		'attachment',
		'attachment/index',
		'attachment/preview',
		'attachment/phone',
		'attachment/redirect',
		'attachment/resize',
		'attachment/download',
		'attachment/*/*',
		'wechat/push',
		'wechat/feedback/*',
		'wechat/feedback/*/*',
	];
}
