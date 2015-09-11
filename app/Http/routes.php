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
use Illuminate\Support\Str;

$hmvc_router = function ($ctrl = 'home', $action = 'index') use ($router)
{
	$route = Route::getCurrentRoute();
	$namespace = $route->getAction()['namespace'];
	$className = $namespace.'\\'.Str::studly($ctrl).'Controller';
	!class_exists($className) && $className = 'Addons\\Core\\Controllers\\'.Str::studly($ctrl).'Controller';
	(!class_exists($className) || !method_exists($className, $action)) && abort(404);

	$class = new ReflectionClass($className);
	$function = $class->getMethod($action); //ReflectionMethod
	$route_parameters = $route->resolveMethodDependencies(
        $route->parametersWithoutNulls(), $function
    );
	$parameters = $function->getParameters(); //ReflectionParameter 
	
	$_data = array();
	$count = count($parameters);
	for ($i=0; $i < $count; $i++)
	{ 
		$key = $parameters[$i]->getName();
		if ( array_key_exists($key, $route_parameters) )
		{
			$_data[] = $route_parameters[$key];
		}
		else if ($parameters[$i]->getClass()) //just in $route_parameters;
		{
			$_data[] = $this->app[$parameters[$i]->getClass()->name];
		} else { //from $_GET/$_POST
			$default = $parameters[$i]->isDefaultValueAvailable() ? $parameters[$i]->getDefaultValue() : NULL;
			$_data[] = array_key_exists($key, $_GET) ? Request::input($key) : $default;
		}
	}
	$obj = new $className;
	// Execute the action itself
	return $obj->callAction($action, $_data);
};

Route::resources([
	'member' => 'MemberController',
]);

Route::bind('user', function($value, $route){
	return \App\User::find($value);
});

Route::group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => 'auth'], function($router) use($hmvc_router) {
	
	Route::resources([
		'member' => 'MemberController',
		'wechat/account' => 'Wechat\\AccountController',
	]);

	Route::group(['namespace' => 'Wechat', 'prefix' => 'wechat', 'middleware' => 'wechat.account'], function($router) use($hmvc_router) {
		Route::resources([
			'user' => 'UserController',
			'depot' => 'DepotController',
			'menu' => 'MenuController',
			'message' => 'MessageController',
			'reply' => 'ReplyController',
		]);
		//admin/wechat/ctrl/data,print,export/json
		Route::any('{ctrl}/{action}/{of}/{jsonp?}', function($ctrl, $action, $of, $jsonp = NULL) use($hmvc_router) {
			app('request')->offsetSet('of', $of);
			app('request')->offsetSet('jsonp', $jsonp);
			return $hmvc_router($ctrl, $action);
		});
	});


	//admin/ctrl/data,print,export/json
	Route::any('{ctrl}/{action}/{of}/{jsonp?}', function($ctrl, $action, $of, $jsonp = NULL) use($hmvc_router) {
		app('request')->offsetSet('of', $of);
		app('request')->offsetSet('jsonp', $jsonp);
		return $hmvc_router($ctrl, $action);
	});

	//admin目录下的其它路由需放置在本条前
	Route::any('{ctrl?}/{action?}', $hmvc_router);
});


//根目录的其它路由需放置在本条前
Route::any('{ctrl?}/{action?}', $hmvc_router);