<?php

namespace King\Backend;

use \Auth;

class AuthUtility{

    /**
     * The greatest role that has all permissions in system
     *
     * @var string $roleMaster Role master
     */
    private $roleMaster = 'ROLE_MASTER';

    /**
     * Check the current user in system or specified user is supper admin or not
     *
     * @param int $userId User id
     *
     * @return bool true(master)|false
     */
    public function checkMaster($userId = null){

        if(is_null($userId)){
            $userId = Auth::user()->id;
        }
        $role = User::find($userId)->getRole()->role;
        if ($role === self::$roleMaster) {

            return true;
        }

        return false;
    }
}