<?php

namespace King\Backend;

class AuthController extends \BaseController{

    protected $layout = 'backend::layouts._auth';

    public function __construct(){
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    /**
     * Display login page and log user in
     *
     * @return void
     */
    public function login(){
        if(\Request::isMethod('POST')){

            $rules = array(
                '_email' => 'required|email',
                '_password' => 'required'
            );

            $validator = \Validator::make(\Input::all(), $rules);
            if($validator->fails()){
                \Session::flash('authErrors', 'Could not authenticate');
               return \Redirect::back()->withInput();
            }else{
                 $login = array(
                    'email' => \Input::get('_email'),
                    'password' => \Input::get('_password')
                );

                if(\Auth::attempt($login, \Input::get('remember'))){
                    return \Redirect::intended('/admin');
                }else{
                    \Session::flash('authErrors', 'Could not authenticate');
                    return \Redirect::back()->withInput();
                }
            }
        }
        $this->layout->content = \View::make('backend::auth.login');
    }


    public function logout(){
        \Auth::logout();
        return \Redirect::to('/admin/auth/login');
    }
}