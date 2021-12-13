<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*
|--------------------------------------------------------------------------
| ExampleController
|--------------------------------------------------------------------------*/
$router->get('/example/get',     'ExampleController@getTest');
$router->post('/example/insert', 'ExampleController@insertTest');
$router->post('/example/delete', 'ExampleController@deleteTest');
$router->post('/example/update', 'ExampleController@updateTest');
$router->post('/example/{id}',   'ExampleController@show');

/*
|--------------------------------------------------------------------------
| TestController
|--------------------------------------------------------------------------*/
$router->get('/test/get', 'TestController@getTest');
