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

$hmvc_router = function ($ctrl = 'home', $action = 'index')
{
  $className = 'App\Http\Controllers\\'.ucfirst(strtolower($ctrl)).'Controller';
  $obj = new $className;
  return $obj->{$action}();
};

Route::any('{ctrl?}/{action?}', $hmvc_router);