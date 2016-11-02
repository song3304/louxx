<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
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
		'attachment/fullavatar-query',
		'attachment/*/*',
		'wechat/push',
		'wechat/feedback/*',
		'wechat/feedback/*/*',
		'install/*',
	];
}
