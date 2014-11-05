<?php

namespace King\Backend;

class CommonController extends \BaseController{

    /**
     * Ajax update the active status
     *
     * @return bool Current active status
     */
    public function _ajaxActive($data){

        list($model, $id) = explode('-', $data);
        $model = ucfirst($model);

        echo _Common::active($model, $id);
    }
}