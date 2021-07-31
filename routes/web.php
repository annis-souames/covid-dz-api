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
    return "API used in Covid 19 Info Algerie website : https://info-covid19-algerie.com/";
});



$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('oxygen',  ['uses' => 'SheetController@getOxygen']);
    $router->get('lovenox', ["uses"=> 'SheetController@getLovenox']);

});
