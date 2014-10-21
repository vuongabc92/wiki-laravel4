<?php

Route::group(['before' => 'guest','prefix' => 'admin/auth'], function($router){
    $router->get('/login', 'King\Backend\AuthController@login');
    $router->post('/login', 'King\Backend\AuthController@login');
});
Route::get('admin/auth/logout', 'King\Backend\AuthController@logout');


Route::group(['before' => 'auth', 'prefix' => '/admin'], function($router){
    $router->get('/', 'King\Backend\IndexController@index');

    $router->resource('/accounts', 'King\Backend\AccountsController');
    $router->get('/account/current-edit', 'King\Backend\AccountsController@currentEdit');
    $router->put('/account/current-save', 'King\Backend\AccountsController@currentSave');
});