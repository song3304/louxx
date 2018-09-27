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

$router->post('/sendCode', 'RegisterController@sendCode');
$router->any('/area/data/json', 'AreaController@data');

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:administrator']], function($router) {
	
	$router->addAdminRoutes([
		'member' => 'MemberController',
	    'properter' => 'ProperterController',
	    'properter-audit' => 'ProperterAuditController',
	    'building' => 'BuildingController',
	    'floor' => 'FloorController',
	    'company' => 'CompanyController',
	    'article' => 'ArticleController',
	    'periphery' => 'PeripheryController',
	    'hire' => 'HireController',
	    'tag' => 'TagController',
	    'area' => 'AreaController',
	    'find-building' => 'FindBuildingController',
	]);

	$router->get('hire/toggle/{id}','HireController@toggle');
	//admin目录下的其它路由需放置在本条前
	$router->addUndefinedRoutes();
});

$router->group(['namespace' => 'Property','prefix' => 'property', 'middleware' => ['auth', 'role:property']], function($router) {
    
        $router->addAdminRoutes([
            'building' => 'BuildingController',
            'floor' => 'FloorController',
            'company' => 'CompanyController',
            'periphery' => 'PeripheryController',
            'hire' => 'HireController',
            'tag' => 'TagController',
            'area' => 'AreaController'
        ]);
    
        $router->get('hire/toggle/{id}','HireController@toggle');
        //admin目录下的其它路由需放置在本条前
        $router->addUndefinedRoutes();
    });


//根目录的其它路由需放置在本条前
$router->addUndefinedRoutes();

