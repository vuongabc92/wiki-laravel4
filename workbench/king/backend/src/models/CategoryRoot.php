<?php namespace King\Backend;

class CategoryRoot extends \Eloquent{

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'category_root';

    public function categoryOnes(){

        return $this->hasMany('King\Backend\CategoryOne');
    }

    public function categoryTwos(){

        return $this->hasMany('King\Backend\CategoryTwo');
    }
}