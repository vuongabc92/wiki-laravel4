<?php namespace King\Backend;

class ContactOnline extends \Eloquent{

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'contact_online';

    public function getContactType(){

        $contactType = ContactType::find($this->contact_type_id);

        return !is_null($contactType) ? $contactType : new ContactType();
    }

}