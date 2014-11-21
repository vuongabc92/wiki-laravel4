<?php namespace King\Backend;

use \View,
    \Request;

class ContactController extends \BaseController{

    /**
     * Layout
     *
     * @var string $layout
     */
    protected $layout = 'backend::layouts._master';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){

        $this->layout->content = View::make('backend::contact.index', array(
            'contacts' => Contact::orderBy('id', 'desc')->paginate('15'),
            'total' => Contact::count()
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id){

        $contact = Contact::find($id);
        if(is_null($contact)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/contacts');
        }

        $this->layout->content = View::make('backend::contact.show', array(
            'contact' => $contact,
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id){

        if(Request::isMethod('DELETE')){

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

    /**
     * Remove all resources
     *
     * @return response
     */
    public function destroyAll(){

        if(Request::isMethod('DELETE')){

            try {
                Contact::truncate();
            } catch (Exception $ex) {
                return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/contacts');
            }

            return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/contacts');
        }

        $this->layout->content = View::make('backend::contact.delete-all-comfirmation', array());
    }
}