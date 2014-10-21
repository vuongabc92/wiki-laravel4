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

            $rules = array(
                'username' => 'required|min:5|max:32|alpha_num',
                'email' => 'required|email|max:100',
                'password' => 'required|min:6|max:60|confirmed',
                'password_confirmation' => 'required',
                'role' => 'required|numeric',
            );

            $msg = array(
                'username.required' => 'Username must be filled',
                'username.min' => 'Username is too short',
                'username.max' => 'Username is too long',
                'email.required' => 'Email must be filled',
                'email.max' => 'Email is too long',
                'password.required' => 'Password must be filled',
                'password.min' => 'Password is too short',
                'password.max' => 'Password is too long',
                'password.confirmed' => 'Password confirmation is not match',
                'password_confirmation.required' => 'Password confirmation must be filled',
                'role.required' => 'Role must be selected',
                'role.numeric' => 'Role must be number'
            );

            $validator = Valid::make(Input::all(), $rules, $msg);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $user = new User();
            $user->username = Input::get('username');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->is_active = Input::get('is_active') ? 1 : 0;
            $user->role_id = Input::get('role');
            $user->save();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
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

}
