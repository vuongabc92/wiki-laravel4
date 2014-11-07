<?php

namespace King\Backend;

use \View,
    \Request,
    \Validator,
    \Input,
    \Redirect,
    \Auth,
    \Session,
    \Hash,
    \Lang;

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

    public $msg = array();

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->msg = array(
                'username.required' => Lang::get('backend::alert.accounts_currentedit_usernamerequired'),
                'username.min' => Lang::get('backend::alert.accounts_currentedit_usernamemin'),
                'username.max' => Lang::get('backend::alert.accounts_currentedit_usernamemax'),
                'username.unique' => Lang::get('backend::alert.accounts_currentedit_usernameunique'),
                'username.alpha_num' => Lang::get('backend::alert.accounts_currentedit_usernamealpha_num'),
                'email.required' => Lang::get('backend::alert.accounts_currentedit_emailrequired'),
                'email.max' => Lang::get('backend::alert.accounts_currentedit_emailmax'),
                'email.email' => Lang::get('backend::alert.accounts_currentedit_emailemail'),
                'email.unique' => Lang::get('backend::alert.accounts_currentedit_emailemail'),
                'password.required' => Lang::get('backend::alert.accounts_currentedit_passrequired'),
                'password.min' => Lang::get('backend::alert.accounts_currentedit_passmin'),
                'password.max' => Lang::get('backend::alert.accounts_currentedit_passmax'),
                'password.confirmed' => Lang::get('backend::alert.accounts_currentedit_passconfirmed'),
                'password_confirmation.required' => Lang::get('backend::alert.accounts_currentedit_passconfirmrequired'),
                'role.required' => Lang::get('backend::alert.accounts_currentedit_rolerequired'),
                'role.numeric' => Lang::get('backend::alert.accounts_currentedit_rolenumeric')
            );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $role = Role::where('role', '=', 'ROLE_MASTER')->first();
        $this->layout->content = View::make('backend::accounts.index', array(
            'users' => User::where('role_id', '!=', $role->id)->get(),
            'total' => User::count()
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
            'roles' => Role::whereRaw('role != ? AND is_active = ?', array('ROLE_MASTER', 1))->get()
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
                Session::flash('adminErrors', Lang::get('backend::alert.fails'));
                return Redirect::back()->withInput();
            }

            return _Common::redirectWithMsg('adminSuccess', Lang::get('backend::alert.save_success'), '/admin/accounts');
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
        $user = User::find($id);
        if(is_null($user)){
            Session::flash('adminWarning', Lang::get('backend::alert.resource_empty'));
            return Redirect::to('/admin/accounts');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return _Common::redirectWithMsg('adminErrors', Lang::get('backend::alert.resource_empty'), '/admin/accounts');
        }

        $this->layout->content = View::make('backend::accounts.edit', array(
            'roles' => Role::whereRaw('role != ? AND is_active = ?', array('ROLE_MASTER', 1))->get(),
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
            if(is_null($user)){
                return _Common::redirectWithMsg('adminErrors', Lang::get('backend::alert.resource_empty'), '/admin/accounts');
            }

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

            $username = Input::get('username');
            $email = Input::get('email');
            $password = Input::get('password');
            if(strlen(trim($username)) > 0){
                $user->username = $username;
            }
            if(strlen(trim($email)) > 0){
                $user->email = $email;
            }
            if(strlen(trim(Input::get('password'))) > 0){
                $user->password = Hash::make(Input::get('password'));
            }
            $user->is_active = Input::get('is_active') ? 1 : 0;
            $user->role_id = Input::get('role');
            try{
                $user->save();
            }  catch (Exception $e){
                Session::flash('adminErrors', Lang::get('backend::alert.fails'));
                return Redirect::back()->withInput();
            }

            return _Common::redirectWithMsg('adminSuccess', Lang::get('backend::alert.save_success'), '/admin/accounts');
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
            $user = User::find($id);
            if(is_null($user)){
                return _Common::redirectWithMsg('adminErrors', Lang::get('backend::alert.resource_empty'), '/admin/accounts');
            }

            try{
                $user->delete();
            } catch (Exception $ex) {
                return _Common::redirectWithMsg('adminErrors', Lang::get('backend::alert.fails'), '/admin/accounts');
            }

            return _Common::redirectWithMsg('adminWarning', Lang::get('backend::alert.delete_success'), '/admin/accounts');
        }
    }

    /**
     * Show the form for editing the logged in user (current user in the system).
     *
     * @return Response
     */
    public function currentEdit()
    {

        $userId = \Auth::user()->id;
        $user = User::find($userId);
        if (is_null($user)) {
            return _Common::redirectWithMsg('adminErrors', Lang::get('backend::alert.resource_empty'), '/admin/accounts');
        }

        $this->layout->content = \View::make('backend::accounts.current_edit', array(
                    'user' => $user
        ));
    }

    /**
     * Update the logged in user resource in storage.
     *
     * @return Response
     */
    public function currentSave()
    {

        if (Request::isMethod('PUT')) {

            $userId = Auth::user()->id;
            $user = User::find($userId);
            if (is_null($user)) {
                return _Common::redirectWithMsg('adminErrors', Lang::get('backend::alert.resource_empty'), '/admin/accounts');
            }

            if(strtolower($user->username) === strtolower(Input::get('username'))){
                $this->rules['username'] = 'required|min:5|max:32|alpha_num';
            }
            if(strtolower($user->email) === strtolower(Input::get('email'))){
                $this->rules['email'] = 'required|email|max:100';
            }
            $this->rules['password'] = 'min:6|max:60|confirmed';
            $this->rules['password_confirmation'] = '';
            $this->rules['role'] = '';
            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $username = Input::get('username');
            $email = Input::get('email');
            $password = Input::get('password');
            if(strlen(trim($username)) > 0){
                $user->username = $username;
            }
            if(strlen(trim($email)) > 0){
                $user->email = $email;
            }
            if(strlen(trim(Input::get('password'))) > 0){
                $user->password = Hash::make(Input::get('password'));
            }

            try{
                $user->save();
            }  catch (Exception $e){
                Session::flash('adminErrors', Lang::get('backend::alert.fails'));
                return Redirect::back()->withInput();
            }
            Auth::logout();

            return _Common::redirectWithMsg('authSuccess', Lang::get('backend::alert.save_success'), '/admin/auth/login');
        }
    }

    /**
     * Ajax update the active status
     *
     * @return bool Current active status
     */
    public function _ajaxActiveAccount($data){

        $this->layout = null;

        list($model, $id) = explode('-', $data);
        $model = ucfirst($model);

        echo CommonUtility::active($model, $id);
    }
}
