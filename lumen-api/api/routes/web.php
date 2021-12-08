<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*
|--------------------------------------------------------------------------
| ExampleController
|--------------------------------------------------------------------------*/
$router->get('/test/get',     'ExampleController@getTest');
$router->post('/test/insert', 'ExampleController@insertTest');
$router->post('/test/delete', 'ExampleController@deleteTest');
$router->post('/test/update', 'ExampleController@updateTest');
$router->post('/test/{id}', 'ExampleController@show');
