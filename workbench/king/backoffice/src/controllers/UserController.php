<?php

namespace King\Backoffice;

use \View;

/**
 * Dashboard controller
 *
 * @author vuongabc92@gmail.com
 */
class UserController extends \BaseController
{
    
    protected $layout = 'backoffice::layout._master';

    /**
     * Display list users
     * 
     * @return void
     */
    public function index()
    {
        $this->layout->content = View::make('backoffice::user.index');
    }
    
    public function create()
    {
        $this->layout->content = View::make('backoffice::user.create');
    }
}
