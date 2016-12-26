<?php
namespace App\Listeners;

use Addons\Core\Events\ControllerEvent;
use Addons\Core\Listeners\ControllerListener as BaseControllerListener;

class ControllerListener extends BaseControllerListener {

	protected $controllerListeners = [
		// eg: Admin\MemberController edit
		// if not matched, auto call class 'App\Listener\Admin\MemberControllerListener@edit'
		// 'App\Http\Controllers\Home*' => [
		// 		'App\Listener\HomeControllerListener', //auto call current controller's method
		// 		'App\Listener\HomeControllerListener@defined_method',
		// 	],
	];

}