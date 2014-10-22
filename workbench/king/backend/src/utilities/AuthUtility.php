<?php

namespace King\Backend;

use \Auth;

class AuthUtility{

    /**
     * @var string $roleMaster Role master
     */
    private static $roleMaster = 'ROLE_MASTER';

    /**
     * Check the logged in user or user with specified id is supper admin or not
     *
     * @param int $userId User id
     *
     * @return bool true(master)|false
     */
    public static function checkMaster($userId = null){

        if(is_null($userId)){
            $userId = Auth::user()->id;
        }
        $role = User::find($userId)->getRole()->role;
        if ($role === self::$roleMaster) {
            return true;
        }
        return false;
    }

    public static function active($model, $id){

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