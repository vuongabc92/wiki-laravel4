<?php

namespace King\Backend;

use \View;

class AboutController extends \BaseController{

    protected $layout = 'backend::layouts._master';

    public function index(){

        $this->layout->content = View::make('backend::about.index');
    }
}