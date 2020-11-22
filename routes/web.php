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

$router->get('/', function () use ($router) {
    return view('index');
});

$router->group(["prefix"=> "task"], function () use ($router) {
    $router->get("/", "TaskController@index");
    $router->get("/find/{id}", "TaskController@find");
    $router->get("/delete/{id}", "TaskController@delete");
    $router->post("/insert", "TaskController@insert");
    $router->post("/update/{id}", "TaskController@update");
});
