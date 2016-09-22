<?php
include_once "User.php";
/**
 * Description of UserHandler
 *
 * @author Edwin
 */
class UserHandler
{
    private static $loggedInUser = null;
    public static function getUserId()
    {
        if (! self::loggedIn()) return 0;
        if (self::$loggedInUser == null){
            self::$loggedInUser = User::getUserByEmail($_COOKIE['ulogin']);
            if (self::$loggedInUser === false) { return 0;}
        }
        return self::$loggedInUser->id();
    }

    public static function loggedIn()
    {
        return (isset($_COOKIE['ulogin']));
    }

    public static function login($logon,$password)
    {
        $user = User::getUserByEmail($logon);
        if ($user === false){ return false;}
        if ($user->checkPassword($password)){
            setcookie("ulogin", $logon, time() + 3600*24);
            $_COOKIE["ulogin"] = $logon;
            return true;
        }
        return false;
    }

    public static function logout()
    {
        if (! self::loggedIn()) {return;}
        setcookie("ulogin", "", time()-36000);
        $key = array_search("ulogin", $_COOKIE);
        unset($_COOKIE[$key]);
    }
}
