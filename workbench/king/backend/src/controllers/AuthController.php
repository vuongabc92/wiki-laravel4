<?php

namespace King\Backend;

use \Request,
    \Validator,
    \Input,
    \Session,
    \Auth,
    \View,
    \Redirect,
    \Lang;

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
        if(Request::isMethod('POST')){

            $rules = array(
                '_email' => 'required|email',
                '_password' => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);
            if($validator->fails()){
                Session::flash('authErrors', Lang::get('backend::alert.auth_login_fails'));
               return Redirect::back()->withInput();
            }else{
                 $login = array(
                    'email' => Input::get('_email'),
                    'password' => Input::get('_password')
                );
                //Login
                if(Auth::attempt($login, Input::get('remember'))){
                    //Check active
                    if(Auth::user()->is_active){
                        return Redirect::intended('/admin');
                    }

                    Auth::logout();
                    Session::flash('authErrors', Lang::get('backend::alert.auth_login_disable'));
                    return Redirect::back()->withInput();
                }else{
                    Session::flash('authErrors', Lang::get('backend::alert.auth_login_fails'));
                    return Redirect::back()->withInput();
                }
            }
        }
        $this->layout->content = View::make('backend::auth.login');
    }


    public function logout(){
        Auth::logout();
        
        return _Common::redirectWithMsg('adminSuccess', 'Logout Success.', '/admin/auth/login');
    }
}