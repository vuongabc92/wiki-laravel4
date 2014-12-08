<?php namespace King\Backend;

class CategoryThree extends \Eloquent{

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'category_three';

    /**
     * @var string Upload folder
     */
    protected $destinationPath = 'uploads/images/category/three';

    /**
     * Get absolute path to file
     *
     * @return string
     */
    public function getAbsolutePath(){
        return public_path() . '/' . $this->destinationPath;
    }

    /**
     * Get destination path to file
     *
     * @return string
     */
    public function getDestinationPath(){
        return $this->destinationPath;
    }

    public function getRoot(){

        $root = CategoryRoot::find($this->category_root_id);

        return !is_null($root) ? $root : new CategoryRoot();
    }

    public function getCategoryOne(){

        $categoryOne = CategoryOne::find($this->category_one_id);

        return !is_null($categoryOne) ? $categoryOne : new CategoryRoot();
    }

    public function getCategoryTwo(){

        $categoryTwo = CategoryTwo::find($this->category_two_id);

        return !is_null($categoryTwo) ? $categoryTwo : new CategoryRoot();
    }

    public function getImage(){
        return $this->destinationPath . '/' . $this->image;
    }
}