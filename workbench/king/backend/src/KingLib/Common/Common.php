<?php namespace King\Backend\Common;

use \Redirect,
    \Session,
    \Route;

class Common{

    /**
     * Update active status for table that have specified model name and primary key
     *
     * @param string $model Model name
     * @param int  $id Primary key
     *
     * @return int Current active status
     */
    public function active($model, $id){

        $model = 'King\Backend\\' . $model;
        $model = $model::find($id);
        if($model->is_active){
            $model->is_active = 0;
        }else{
            $model->is_active = 1;
        }

        $model->save();

        return $model->is_active;
    }

    /**
     * Change string datetime to other format
     *
     * @param string $datetime
     * @param string $format (d/m/Y, Y-m-d,...)
     *
     * @return string Datetime string with format was set
     */
    public function changeDatetimeFormat($datetime, $format){

        $date = new \DateTime($datetime);

        return $date->format($format);
    }


    /**
     * Find specified resources
     *
     * @param string $sessionID Id of session flash
     * @param string $sessionMsg Message of session flash
     * @param string $urlTo URL will be redirected to
     *
     * @return string Datetime string with format was set
     */
    public function redirectWithMsg($sessionID, $sessionMsg, $urlTo){

        Session::flash($sessionID, $sessionMsg);
        return Redirect::to($urlTo);
    }

    /**
     * Get max order number
     *
     * @param string $model Model class name
     * @param string $column Order number column
     *
     * @return int max order number
     */
    public function getMaxOrderNumber($model, $column = 'order_number'){

        return $model::max($column);
    }

    /**
     * Get current path 
     */
    public function getCurrentNav(){

        $currentPath = Route::getCurrentRoute()->getPath();
        list(, $nav) = explode('/', $currentPath);

        return $nav;
    }
}