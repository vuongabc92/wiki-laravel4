<?php

namespace King\Backend;

class IndexController extends \BaseController{

    protected $layout = 'backend::layouts._master';

    public function index(){

        $this->layout->content = \View::make('backend::index.index');
    }
}