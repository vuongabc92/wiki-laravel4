<?php namespace King\Backend\Knight;

use \Auth,
    King\Backend\User;

class Knight{

    /**
     * The role has perssion access to all resources
     *
     * @var string $roleMaster Role master
     */
    private static $roleMaster = 'ROLE_MASTER';

    /**
     * The role has perssion access to specify resources
     *
     * @var string $roleAdmin Role admin
     */
    private static $roleAdmin = 'ROLE_ADMIN';

    /**
     * Check the current user in system or specified user is MASTER or not
     *
     * @param int $userId User id
     *
     * @return bool true(master)|false
     */
    public static function isMaster($userId = null){

        if(is_null($userId)){
            $userId = \Auth::user()->id;
        }
        $role = User::find($userId)->getRole()->role;
        if ($role === self::$roleMaster) {

            return true;
        }

        return false;
    }

    /**
     * Check the current user in system or specified user is ADMIN or not
     *
     * @param int $userId User id
     *
     * @return bool true(admin)|false
     */
    public static function isAdmin($userId = null){

        if(is_null($userId)){
            $userId = \Auth::user()->id;
        }
        $role = User::find($userId)->getRole()->role;
        if ($role === self::$roleAdmin) {

            return true;
        }

        return false;
    }
}