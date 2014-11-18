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
    protected $destinationPath = 'uploads/images/category';

    public function categoryTwos(){

        return $this->hasMany('King\Backend\CategoryTwo');
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
        return CategoryRoot::find($this->category_root_id);
    }
}