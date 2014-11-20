<?php namespace King\Backend;

use \View;

class ContactController extends \BaseController{

    /**
     * Layout
     *
     * @var string $layout
     */
    protected $layout = 'backend::layouts._master';


    public function index(){

        $this->layout->content = View::make('backend::contact.index', array(
            'contacts' => Contact::all(),
            'total' => Contact::count()
        ));
    }

    public function show($id){

        $contact = Contact::find($id);
        if(is_null($contact)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/contacts');
        }

        $this->layout->content = View::make('backend::contact.show', array(
            'contact' => $contact,
        ));
    }

    public function destroy($id){

        $contact = Contact::find($id);
        if(is_null($contact)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/contacts');
        }

        try{
            $contact->delete();
        } catch (Exception $ex) {
            return _Common::redirectWithMsg('adminErrors', 'Opp! please try again.', '/admin/contacts');
        }

        return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/contacts');
    }
}