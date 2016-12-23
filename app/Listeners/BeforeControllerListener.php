<?php
namespace App\Listeners;

use Addons\Core\Events\BeforeControllerEvent;
use Addons\Core\Listeners\BeforeControllerListener as BaseBeforeControllerListener;

class BeforeControllerListener extends BaseBeforeControllerListener {

	protected $controllerListeners = [
		// eg: Admin\MemberController edit
		// if not matched, auto call class 'App\Listener\Admin\MemberControllerBeforeListener@edit'
		// 'App\Http\Controllers\Home*' => [
		// 		'App\Listener\HomeControllerBeforeListener', //auto call current controller's method
		// 		'App\Listener\HomeControllerBeforeListener@defined_method',
		// 	],
	];

}