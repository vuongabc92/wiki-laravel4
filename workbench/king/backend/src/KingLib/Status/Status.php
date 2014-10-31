<?php namespace King\Backend\Status;

class Status{

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
     * Change string datetime to other format suchc as: d/m/Y, Y-m-d,...
     *
     * @param string $datetime
     * @param string $format
     *
     * @return string Datetime string with format was set
     */
    public function changeDatetimeFormat($datetime, $format){

        $date = new \DateTime($datetime);

        return $date->format($format);
    }

}