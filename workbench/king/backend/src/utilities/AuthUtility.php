<?php

namespace King\Backend;

class AuthUtility{

    private static $masterRole = 'ROLE_MASTER';

    public static function checkMaster(){

        if(\Auth::user()->role === self::$masterRole){
            return true;
        }
        return false;
    }
}