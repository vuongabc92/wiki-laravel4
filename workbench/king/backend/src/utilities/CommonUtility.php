<?php

namespace King\Backend;

class CommonUtility{


    /**
     * Update active status for table that have specified model name and primary key
     *
     * @param string $model Model name
     * @param int  $id Primary key
     *
     * @return int Current active status
     */
    public static function active($model, $id){

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


}