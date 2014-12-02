<?php namespace King\Backend;

class CategoryOne extends \Eloquent{

    /**
     * Table name
     *
     * @var string $table
     */
    protected $table = 'category_one';

    /**
     * @var string Upload folder
     */
    protected $destinationPath = 'uploads/images/category/one';

    public function categoryTwos(){

        return $this->hasMany('King\Backend\CategoryTwo');
    }

    public function categoryThrees(){

        return $this->hasMany('King\Backend\CategoryThree');
    }

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

    public function getImage(){
        return $this->destinationPath . '/' . $this->image;
    }
}