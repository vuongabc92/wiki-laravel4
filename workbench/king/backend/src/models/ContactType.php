<?php namespace King\Backend;

class ContactType extends \Eloquent{

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'contact_type';

    public function contactOnlines(){

        return $this->hasMany('King\Backend\ContactOnline');
    }

}