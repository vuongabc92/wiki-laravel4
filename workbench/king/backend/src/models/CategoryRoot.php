<?php namespace King\Backend;

class CategoryRoot extends \Eloquent{

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'category_root';

    public function categoryOne(){

        return $this->hasMany('CategoryOne');
    }
}