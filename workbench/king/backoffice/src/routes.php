<?php

Route::group(array('prefix' => 'master'), function($route){
    
    $route->get('/', array('as' => 'dashboard', 'uses' => 'King\Backoffice\DashboardController@index'));
    
    //Routes user
    $route->get('user', array('as' => 'user', 'uses' => 'King\Backoffice\UserController@index'));
    $route->get('user/create', array('as' => 'user', 'uses' => 'King\Backoffice\UserController@create'));
});