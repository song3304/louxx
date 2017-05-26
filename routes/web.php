<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
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

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:administrator']], function($router) {
	
	$router->addAdminRoutes([
		'member' => 'MemberController',
	    'properter' => 'ProperterController',
	    'properter-audit' => 'ProperterAuditController',
	    'building' => 'BuildingController',
	    'floor' => 'FloorController',
	    'company' => 'CompanyController',
	    'article' => 'ArticleController',
	    'hire' => 'HireController',
	    'tag' => 'TagController',
	    'area' => 'AreaController',
	]);

	//admin目录下的其它路由需放置在本条前
	$router->addUndefinedRoutes();
});

//根目录的其它路由需放置在本条前
$router->addUndefinedRoutes();

