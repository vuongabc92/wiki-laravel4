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
        return CategoryRoot::find($this->root_id);
    }
}