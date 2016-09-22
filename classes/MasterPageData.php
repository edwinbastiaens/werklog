<?php
class MasterPageData
{
    private static $title = "Werklog";
    public static function title($title="",$echo=true)
    {
        if ($title!= ""){
            self::$title = $title;
            return;
        }
        if ($echo){
            echo self::$title;
        } else {
            return self::$title;
        }
    }

    private static $main = "";
    public static function main($main="",$echo=true)
    {
        if ($main!= ""){
            self::$main = $main;
            return;
        }
        if ($echo){
            echo self::$main;
        } else {
            return self::$main;
        }
    }
}
