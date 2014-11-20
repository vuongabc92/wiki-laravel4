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

        $this->layout->content = View::make('backend::contact.show', array(
            'contact' => Contact::find($id),
        ));
    }

    public function destroy($id){

        $this->layout->content = View::make('backend::contact.show', array(
            'contact' => Contact::find($id),
        ));
    }
}