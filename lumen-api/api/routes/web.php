<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/test', function () {
    $test = array(
        "success" => "true",
        "item"    => null
    );

    return $test;
});

/*
|--------------------------------------------------------------------------
| ExampleController
|--------------------------------------------------------------------------*/
$router->get('/test/get', 'ExampleController@getTest');
$router->post('/test/insert', 'ExampleController@insertTest');
$router->post('/test/delete', 'ExampleController@deleteTest');
