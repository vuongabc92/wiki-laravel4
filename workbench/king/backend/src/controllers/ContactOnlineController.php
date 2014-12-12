<?php namespace King\Backend;

use \View,
    \Session,
    \Redirect,
    \Validator,
    \Request,
    \Input,
    \File;

class ContactOnlineController extends \BaseController
{

    /**
     * @var string $layout layout controller
     */
    protected $layout = 'backend::layouts._master';

    /**
     * @var array $rules Insert|update rules
     */
    public $rules = array(
        'contact_type_id' => 'required|numeric',
        'name' => 'min:3|max:32',
        'contact' => 'required|min:3|max:255'
    );

    /**
     * @var array $msg Insert|update rules
     */
    public $msg = array(
        'contact_type_id.required' => 'The contact type field is required.',
        'contact_type_id.numeric' => 'The contact type field must be a number.',
        'name.min' => 'The name is too short.',
        'name.max' => 'The name is too long.',
        'contact.required' => 'The contact field is required.',
        'contact.min' => 'The contact is too short.',
        'contact.max' => 'The contact is too long.',
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
        $filter = new \stdClass();
        $filter->id = 0;
        $filter->name = 'All';
        $this->layout->content = View::make('backend::contact-online.index', array(
            'online' => ContactOnline::paginate(15),
            'total' => ContactOnline::count(),
            'contactType' => ContactType::where('is_active', '=', 1)->get(),
            'filter' => $filter
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->content = View::make('backend::contact-online.create', array(
            'contactType' => ContactType::where('is_active', '=', 1)->get(),
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
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $contact = new ContactOnline();
            $contact->contact_type_id = Input::get('contact_type_id');
            $contact->name = Input::get('name');
            $contact->contact = Input::get('contact');
            $contact->is_active = ! is_null(Input::get('is_active')) ? 1 : 0;

            try{
                $contact->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::back()->withInput();
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/contact-online');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $online = ContactOnline::find($id);
        if(is_null($online)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/contact-online');
        }

        $this->layout->content = View::make('backend::contact-online.edit', array(
            'online' => $online,
            'contactType' => ContactType::where('is_active', '=', 1)->get(),
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

            $contact = ContactOnline::find($id);
            if(is_null($contact)){
                return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/contact-online');
            }

            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $contact->contact_type_id = Input::get('contact_type_id');
            $contact->name = Input::get('name');
            $contact->contact = Input::get('contact');
            $contact->is_active = ! is_null(Input::get('is_active')) ? 1 : 0;

            try{
                $contact->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::back()->withInput();
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/contact-online');
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
        $contact = ContactOnline::find($id);
            if(is_null($contact)){
                return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/contact-online');
            }

        try{
            $contact->delete();
        } catch (Exception $ex) {
            return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/contact-online');
        }

        return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/contact-online');
    }

    /**
     * Remove all resources
     *
     * @return response
     */
    public function destroyAll(){

        if(Request::isMethod('DELETE')){

            try {
                ContactOnline::truncate();
            } catch (Exception $ex) {
                return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/contact-online');
            }

            return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/contact-online');
        }

        $this->layout->content = View::make('backend::contact-online.delete-all-comfirmation', array());
    }

    /**
     * Filter category one via category root.
     *
     * @param string $root Some string like root-{id-root}
     * @return Response
     */
    public function filterContactType($id){

        $type = ContactType::find($id);
        if (is_null($type)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/contact-online');
        }
        $online = $type->contactOnlines()->paginate(15);
        $this->layout->content = View::make('backend::contact-online.index', array(
            'online' => $online,
            'total' => ContactOnline::count(),
            'contactType' => ContactType::where('is_active', '=', 1)->get(),
            'filter' => $type
        ));
    }
}
