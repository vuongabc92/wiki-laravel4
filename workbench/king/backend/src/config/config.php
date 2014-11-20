<?php

/**
 * Config
 */

return array(

    'navs' => array(
        array(
            'url' => 'admin',
            'txt' => 'Dashboard',
            'nav_name' => '',
            'icon' => 'fa fa-dashboard'
        ),
        array(
            'url' => 'admin/accounts',
            'txt' => 'Accounts',
            'nav_name' => 'accounts',
            'icon' => 'fa fa-users'
        ),
        array(
            'url' => 'admin/roles',
            'txt' => 'Roles',
            'nav_name' => 'roles',
            'icon' => 'fa fa-lock'
        ),
        array(
            'url' => 'admin/post',
            'txt' => 'Posts',
            'nav_name' => 'post',
            'icon' => 'fa fa-file-text'
        ),
        array(
            'url' => 'admin/category-root',
            'txt' => 'Category root',
            'nav_name' => 'category-root',
            'icon' => 'fa fa-anchor'
        ),
        array(
            'url' => 'admin/category-one',
            'txt' => 'Category one',
            'nav_name' => 'category-one',
            'icon' => 'fa fa-list-ul'
        ),
        array(
            'url' => 'admin/category-two',
            'txt' => 'Category two',
            'nav_name' => 'category-two',
            'icon' => 'fa fa-list'
        ),
    ),
    'active_nav_class' => 'active-nav'

);