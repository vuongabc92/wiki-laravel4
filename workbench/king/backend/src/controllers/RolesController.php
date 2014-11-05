<?php namespace King\Backend;

use \View,
    \Request,
    \Input,
    \Redirect,
    \Validator,
    \Session;

class RolesController extends \BaseController
{

    protected $layout = 'backend::layouts._master';

    /**
     * @var array $rules Insert|update rules
     */
    public $rules = array(
        'role_name' => 'required|min:3|max:32|unique:roles,role_name',
        'role' => 'required|min:3|max:32|alpha_dash|unique:roles,role',
    );

    /**
     * @var array $msg Insert|update rules
     */
    public $msg = array(
        'role_name.required' => 'The role name field is required.',
        'role_name.min' => 'The role name is too short.',
        'role_name.max' => 'The role name is too long.',
        'role_name.unique' => 'The role name has already been taken.',
        'role.required' => 'The role field is required.',
        'role.min' => 'The role is too short.',
        'role.max' => 'The role is too long.',
        'role.unique' => 'The role has already been taken.',
        'role.alpha_dash' => 'The role may only contain letters, numbers, and dashes, such as: ROLE_ADMIN, ROLE_VIEWER.'
    );

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->layout->content = View::make('backend::roles.index', array(
            'roles' => Role::all(),
            'total' => Role::count()
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->content = View::make('backend::roles.create', array());
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
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $role = new Role();
            $role->role_name = Input::get('role_name');
            $role->role = Input::get('role');
            $role->is_active = !is_null(Input::get('is_active')) ? Input::get('is_active') : 0;

            try{
                $role->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::to('/admin/roles');
            }

            Session::flash('adminSuccess', 'Add new role successful!');
            return Redirect::to('/admin/roles');
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
        $this->layout->content = View::make('backend::roles.edit', array(
            'role' => Role::find($id),
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

            $role = Role::find($id);
            if(is_null($role)){
                Session::flash('adminWarning', 'Resource does not exist!');
                return Redirect::to('/admin/roles');
            }

            if(Input::get('role_name') === $role->role_name){
                $this->rules['role_name'] = 'required|min:3|max:32';
            }

            if(Input::get('role') === $role->role){
                $this->rules['role'] = 'required|min:3|max:32|alpha_dash';
            }

            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $role->role_name = Input::get('role_name');
            $role->role = Input::get('role');
            $role->is_active = !is_null(Input::get('is_active')) ? Input::get('is_active') : 0;

            try{
                $role->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::to('/admin/roles');
            }

            Session::flash('adminSuccess', 'Save role successful!');
            return Redirect::to('/admin/roles');
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
            $role = Role::find($id);

            if(is_null($role)){
                Session::flash('adminWarning', 'Resource does not exist!');
                return Redirect::to('/admin/roles');
            }

            $role->delete();

            Session::flash('adminWarning', 'Delete role successful !');
            return Redirect::to('/admin/roles');
        }
    }

}
