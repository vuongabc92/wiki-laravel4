<?php namespace King\Backend;

use \View;

class GUIController extends \BaseController{

    protected $layout = 'backend::layouts._master';

    public function index(){

        $this->layout->content = View::make('backend::gui.index');
    }
}