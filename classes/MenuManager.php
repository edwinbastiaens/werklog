<?php
class MenuManager
{
    public static $curPage = "home";
    public static function init($curPage="home")
    {
        self::$curPage = $curPage;
    }

    public static function getMenu()
    {
        $ret = "";
        $menu = self::getMenuConfig();
        foreach ($menu as $name => $url)
        {
            $ret .= "<li><a class='".(($name==self::$curPage)?"wt":"")." ui-link' "
                    . "href='".$url."'>".ucfirst($name)."</a>"
                . "</li>";
        }
        return $ret;
    }

    public static function getMenuConfig()
    {

        $home = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $h = substr($home, 0, strrpos($home, "/")+1);
        $arr = array("home" => $h);

        if (UserHandler::loggedIn()){
            $arr["logoff"] = "logoff.php";
        } else {
            $arr["logon"] = "logon.php";
            $arr["registreer"] = "register.php";
        }
        return $arr;
    }
}
