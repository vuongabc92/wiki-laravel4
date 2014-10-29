<?php

namespace King\Backend;

class Post extends \Eloquent{

    protected $table = 'post';

    /**
     * @var string Upload folder
     */
    protected $destinationPath = 'uploads/images/post';

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
}