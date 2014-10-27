<?php

Route::group(['before' => 'guest','prefix' => 'admin/auth'], function($router){
    $router->get('/login', 'King\Backend\AuthController@login');
    $router->post('/login', 'King\Backend\AuthController@login');
});
Route::get('admin/auth/logout', 'King\Backend\AuthController@logout');


Route::group(['before' => 'auth', 'prefix' => '/admin'], function($router){
    $router->get('/', 'King\Backend\IndexController@index');

    //Accounts
    Route::group(['before' => 'master'], function($router){
        $router->resource('/accounts', 'King\Backend\AccountsController');
        $router->get('/account/active/{data}', 'King\Backend\AccountsController@_ajaxActiveAccount');
    });
    $router->get('/account/current-edit', 'King\Backend\AccountsController@currentEdit');
    $router->put('/account/current-save', 'King\Backend\AccountsController@currentSave');

    //About
    $router->get('/about', 'King\Backend\AboutController@index');

    //Post
    $router->resource('/post', 'King\Backend\PostController');
});