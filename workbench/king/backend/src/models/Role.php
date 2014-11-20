<?php namespace King\Backend;

class Role extends \Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    public function users(){

        return $this->hasMany('King\Backend\User');
    }
}
