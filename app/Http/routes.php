<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//$router->pattern('id', '[0-9]+'); //所有id都是数字

Route::resources([
	'member' => 'MemberController',
]);

Route::any('wechat/feedback/{id}', 'WechatController@feedback');

Route::group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:admin|manager|owner|leader']], function($router) {
	
	$this->setAdminRoutes([
		'role' => 'RoleController',
		'permission' => 'PermissionController',
		'member' => 'MemberController',
		'wechat/account' => 'Wechat\\AccountController',
	]);

	Route::group(['namespace' => 'Wechat', 'prefix' => 'wechat', 'middleware' => 'wechat.account'], function($router) {
		$this->setAdminRoutes([
			'user' => 'UserController',
			'depot' => 'DepotController',
			'menu' => 'MenuController',
			'message' => 'MessageController',
			'reply' => 'ReplyController',
		]);
	});


	//admin目录下的其它路由需放置在本条前
	$this->setUndefinedRoutes();
});


//根目录的其它路由需放置在本条前
$this->setUndefinedRoutes();