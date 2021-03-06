<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->welcome();
});

$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function($app)
{
    $app->get('verify','UserController@verifyUser');
  
    $app->post('user','UserController@createUser');

    $app->post('user/resend','UserController@resendVerification');
      
});

$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers', 'middleware' => 'App\Http\Middleware\EasyAuthMiddleware'], function($app)
{     
  	$app->get('group','GiftGroupController@index');    

  	$app->post('group/resend','GiftGroupController@resendEmail');    
});

$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers', 'middleware' => 'App\Http\Middleware\EasyAuthAdminMiddleware'], function($app)
{     
	$app->post('group/adduser','GiftGroupController@addUser');    

  	$app->post('group/draw','GiftGroupController@performDraw');    
});