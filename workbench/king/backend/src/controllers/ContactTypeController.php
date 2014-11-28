<?php namespace King\Backend;

use \View,
    \Session,
    \Redirect,
    \Validator,
    \Request,
    \Input;

class ContactTypeController extends \BaseController
{

    /**
     * @var string $layout layout controller
     */
    protected $layout = 'backend::layouts._master';

    /**
     * @var array $rules Insert|update rules
     */
    public $rules = array(
        'name' => 'required|min:3|max:255|unique:category_root,name',
    );

    /**
     * @var array $msg Insert|update rules
     */
    public $msg = array(
        'name.required' => 'The name field is required.',
        'name.min' => 'The name is too short.',
        'name.max' => 'The name is too long.',
        'name.unique' => 'The name has already been taken.'
    );

    /**
     * Constructor
     */
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
        $this->layout->content = View::make('backend::contact-type.index', array(
            'types' => ContactType::paginate(15),
            'total' => ContactType::count()
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->content = View::make('backend::contact-type.create');
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

            $contactType = new ContactType();
            $contactType->name = Input::get('name');
            $contactType->is_active = ! is_null(Input::get('is_active')) ? 1 : 0;

            try{
                $contactType->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::back()->withInput();
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/contact-type');
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
        $type = ContactType::find($id);
        if(is_null($type)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/contact-type');
        }

        $this->layout->content = View::make('backend::contact-type.edit', array(
            'type' => $type
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

            $type = ContactType::find($id);
            if(is_null($type)){
                return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/contact-type');
            }

            if(strtolower(Input::get('name')) === strtolower($type->name)){
                $this->rules['name'] = 'required|min:3|max:255';
            }

            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $type->name = Input::get('name');
            $type->is_active = !is_null(Input::get('is_active')) ? 1 : 0;

            try{
                $type->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::back()->withInput();
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/contact-type');
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
        $type = ContactType::find($id);
        if (is_null($type)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/contact-type');
        }

        try{
            $type->delete();
        } catch (Exception $ex) {
            return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/contact-type');
        }

        return _Common::redirectWithMsg('adminWarning', 'Delete Success.', '/admin/contact-type');
    }

}
