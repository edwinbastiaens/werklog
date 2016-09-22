<?php
/**
 * Library with time related functions
 *
 * @author Edwin
 */
class TimeLib
{
    public static function secs2time($s){
        $h = floor($s / 3600);
        $s2 = $s % 3600;
        $m = floor($s2 / 60);
        if ($m < 10)  $m = '0' . $m;
        $ss = $s2 % 60;
        return $h . ":" . $m . ":" . $ss;
    }
}
