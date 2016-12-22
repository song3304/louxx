<?php
namespace App\Listeners;

use Addons\Core\Events\BeforeControllerEvent;
use Addons\Core\Listeners\BeforeControllerListener as BaseBeforeControllerListener;

class BeforeControllerListener extends BaseBeforeControllerListener {

	// auto call class 'Namespace\App\Listener\ControllerBeforeListener' without defined
	protected $controllerListeners = [
		// 'App\Http\Controllers\HomeController' => [
		// 		'App\Listener\HomeControllerBeforeListener', //auto @handle
		// 		'App\Listener\HomeControllerBeforeListener1@function',
		// 	],
	];

}