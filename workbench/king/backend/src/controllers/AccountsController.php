<?php

namespace King\Backend;

use \View,
    \Request,
    \Validator,
    \Input,
    \Redirect,
    \Auth,
    \Session,
    \Hash;

class AccountsController extends \BaseController
{

    protected $layout = 'backend::layouts._master';

    public $rules = array(
                'username' => 'required|min:5|max:32|alpha_num|unique:users,username',
                'email' => 'required|email|max:100|unique:users,email',
                'password' => 'required|min:6|max:60|confirmed',
                'password_confirmation' => 'required',
                'role' => 'required|numeric',
            );

    public $msg = array(
                'username.required' => 'The username field is required.',
                'username.min' => 'The username must be at least 5 characters.',
                'username.max' => 'The username may not be greater than 32 characters.',
                'username.unique' => 'The username has already been taken.',
                'email.required' => 'The email field is required.',
                'email.max' => 'The username may not be greater than 100 characters.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 5 characters.',
                'password.max' => 'The username may not be greater than 60 characters.',
                'password.confirmed' => 'The password confirmation does not match.',
                'password_confirmation.required' => 'The password confirmation field is required.',
                'role.required' => 'The role field must be selected.',
                'role.numeric' => 'The role must be a number.'
            );

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->layout->content = View::make('backend::accounts.index', array(
            'users' => User::all()
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->content = View::make('backend::accounts.create', array(
            'roles' => Role::where('role', '!=', 'ROLE_MASTER')->get()
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if(Request::isMethod('POST')){

            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $user = new User();
            $user->username = Input::get('username');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->is_active = Input::get('is_active') ? 1 : 0;
            $user->role_id = Input::get('role');
            try{
                $user->save();
            }  catch (Exception $e){
                Session::flash('adminErrors', 'Opp! please again!!');
                return Redirect::back()->withInput();
            }
            Session::flash('adminSuccess', 'Save account success!!');
            return Redirect::to('/admin/accounts');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $this->layout->content = View::make('backend::accounts.edit', array(
            'roles' => Role::where('role', '!=', 'ROLE_MASTER')->get(),
            'user' => User::find($id)
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        if(Request::isMethod('PUT')){

            $user = User::find($id);
            if(strtolower($user->username) === strtolower(Input::get('username'))){
                $this->rules['username'] = 'required|min:5|max:32|alpha_num';
            }
            if(strtolower($user->email) === strtolower(Input::get('email'))){
                $this->rules['email'] = 'required|email|max:100';
            }
            $this->rules['password'] = 'min:6|max:60|confirmed';
            $this->rules['password_confirmation'] = '';
            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput();
            }


            $user->username = Input::get('username');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->is_active = Input::get('is_active') ? 1 : 0;
            $user->role_id = Input::get('role');
            try{
                $user->save();
            }  catch (Exception $e){
                Session::flash('adminErrors', 'Opp! please again!!');
                return Redirect::back()->withInput();
            }
            Session::flash('adminSuccess', 'Save account success!!');
            return Redirect::to('/admin/accounts');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if(Request::isMethod('DELETE')){
            User::find($id)->delete();
            Session::flash('adminWarning', 'Delete account success!');
            return Redirect::to('admin/accounts');
        }
    }

    public function currentEdit()
    {

        $userId = \Auth::user()->id;
        $user = User::find($userId);

        $this->layout->content = \View::make('backend::accounts.current_edit', array(
                    'user' => $user
        ));
    }

    public function currentSave()
    {

        if (Request::isMethod('PUT')) {

            $rules = array(
                'username' => 'min:5|max:32|alpha_num',
                'email' => 'email|max:100',
                'password' => 'min:5|max:60|confirmed',
            );

            $msg = array(
                'username.min' => 'Username is too short',
                'username.max' => 'Username is too long',
                'username.alpha_num' => 'Username must be in list of alpha number',
                'email.email' => 'Email format is in valid',
                'email.max' => 'Email is too long',
                'password.min' => 'Password is too short',
                'password.max' => 'Password is too long',
                'password.confirmed' => 'Password confirmation is incorrect',
            );

            $validator = Validator::make(Input::all(), $rules, $msg);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            } else {

                $userId = \Auth::user()->id;
                $user = User::find($userId);
                if (Input::has('username')) {
                    $user->username = \Input::get('username');
                }
                if (Input::has('email')) {
                    $user->email = \Input::get('email');
                }
                if (Input::has('password')) {
                    $user->password = \Input::get('password');
                }
                $user->save();
                Auth::logout();
                Session::flash('authSuccess', 'Your account has changed success, please login again!');
                return Redirect::to('/admin/auth/login');
            }
        }
    }

    public function _ajaxActiveAccount($data){

        $this->layout = null;

        list($model, $id) = explode('-', $data);
        $model = ucfirst($model);
        echo AuthUtility::active($model, $id);
    }
}
