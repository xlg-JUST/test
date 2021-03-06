<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('gaslevel', 'GaslevelController');
    $router->resource('temperature', 'TemperatureController');
    $router->resource('windspeed', 'WindspeedController');
    $router->resource('dustlevel', 'DustlevelController');
    $router->resource('query', 'QueryController');
    $router->resource('analysis', 'AnalysisController');
    $router->resource('safety', 'SafetyController');
    $router->resource('alert', 'AlertController');
    $router->resource('help', 'HelpController');
//    $router->resource('图纸解析', 'D:\Toolbar\phpstudy_pro\WWW\test.local');


});
