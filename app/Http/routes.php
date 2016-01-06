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

$router->resources([
	'member' => 'MemberController',
]);

$router->any('wechat/feedback/{aid}/{oid?}', 'WechatController@feedback');
$router->addAnyActionRoutes([
	'wechat',
]);

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:admin|manager|owner|leader']], function($router) {
	
	$router->addAdminRoutes([
		'member' => 'MemberController',
	]);

	//admin目录下的其它路由需放置在本条前
	$router->addUndefinedRoutes();
});


//根目录的其它路由需放置在本条前
$router->addUndefinedRoutes();