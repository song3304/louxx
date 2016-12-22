<?php
namespace App\Listeners;

use Addons\Core\Events\ControllerEvent;
use Addons\Core\Listeners\ControllerListener as BaseControllerListener;

class ControllerListener extends BaseControllerListener {

	// auto call class 'Namespace\App\Listener\ControllerListener' without defined
	protected $controllerListeners = [
		// 'App\Http\Controllers\HomeController' => [
		// 		'App\Listener\HomeControllerListener', //auto @handle
		// 		'App\Listener\HomeControllerListener1@function',
		// 	],
	];

}