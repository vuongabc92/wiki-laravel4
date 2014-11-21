<?php

Route::group(['before' => 'guest','prefix' => 'admin/auth'], function($router){
    $router->get('/login', 'King\Backend\AuthController@login');
    $router->post('/login', 'King\Backend\AuthController@login');
    Route::controller('/password', 'King\Backend\RemindersController');
});

Route::get('admin/auth/logout', 'King\Backend\AuthController@logout');

Route::group(['before' => 'auth', 'prefix' => '/admin'], function($router){
    $router->get('/', 'King\Backend\IndexController@index');

    //Accounts
    Route::group(['before' => 'master'], function($router){
        //Accounts
        $router->resource('/accounts', 'King\Backend\AccountsController');
        $router->get('/account/active/{data}', 'King\Backend\CommonController@_ajaxActive');

        //Roles
        $router->resource('/roles', 'King\Backend\RolesController');
        $router->get('/roles/active/{data}', 'King\Backend\CommonController@_ajaxActive');
    });
    $router->get('/account/current-edit', 'King\Backend\AccountsController@currentEdit');
    $router->put('/account/current-save', 'King\Backend\AccountsController@currentSave');

    //About
    $router->get('/about', 'King\Backend\AboutController@index');

    //Post
    $router->resource('/post', 'King\Backend\PostController');
    $router->delete('/post/delete-image/{id}', 'King\Backend\PostController@destroyImg');

    //Category root
    $router->resource('/category-root', 'King\Backend\CategoryRootController');

    //Category one
    $router->match(array('GET','DELETE'), '/category-one/delete-all', 'King\Backend\CategoryOneController@destroyAll');
    $router->resource('/category-one', 'King\Backend\CategoryOneController');
    $router->get('/category-one/filter/{root}', 'King\Backend\CategoryOneController@filterRoot');
    $router->delete('/category-one/delete-image/{id}', 'King\Backend\CategoryOneController@destroyImg');

    //Category two
    $router->match(array('GET','DELETE'), '/category-two/delete-all', 'King\Backend\CategoryTwoController@destroyAll');
    $router->resource('/category-two', 'King\Backend\CategoryTwoController');
    $router->get('/category-two/filter-category-root/{id}', 'King\Backend\CategoryTwoController@filterWithCategoryRoot');
    $router->get('/category-two/filter-category-one/{id}', 'King\Backend\CategoryTwoController@filterWithCategoryOne');
    $router->get('/category-two/filter-category-one-and-root/{idRoot}/{idOne}', 'King\Backend\CategoryTwoController@filterWithCategoryOneAndRoot');
    $router->delete('/category-two/delete-image/{id}', 'King\Backend\CategoryTwoController@destroyImg');
    $router->get('/category-two/create-filter/{id}', 'King\Backend\CategoryTwoController@_ajaxFilterCategoryRoot');

    //Category three
    $router->match(array('GET','DELETE'), '/category-three/delete-all', 'King\Backend\CategoryThreeController@destroyAll');
    $router->resource('/category-three', 'King\Backend\CategoryThreeController');
    $router->get('/category-three/filter-category-root/{id}', 'King\Backend\CategoryThreeController@filterWithCategoryRoot');
    $router->get('/category-three/filter-category-one/{id}', 'King\Backend\CategoryThreeController@filterWithCategoryOne');
    $router->get('/category-three/filter-category-one-and-root/{idRoot}/{idOne}', 'King\Backend\CategoryThreeController@filterWithCategoryOneAndRoot');
    $router->delete('/category-three/delete-image/{id}', 'King\Backend\CategoryThreeController@destroyImg');
    $router->get('/category-three/create-filter/{id}', 'King\Backend\CategoryThreeController@_ajaxFilterCategoryRoot');
    $router->get('/category-three/create-filter-one/{id}', 'King\Backend\CategoryThreeController@_ajaxFilterCategoryOne');

    //Contact
    $router->match(array('GET','DELETE'), '/contacts/delete-all', 'King\Backend\ContactController@destroyAll');
    $router->get('/contacts', 'King\Backend\ContactController@index');
    $router->get('/contacts/{id}', 'King\Backend\ContactController@show');
    $router->delete('/contacts/{id}', 'King\Backend\ContactController@destroy');

    //Change active status
    $router->get('/ajax/active/{data}', 'King\Backend\CommonController@_ajaxActive');
});