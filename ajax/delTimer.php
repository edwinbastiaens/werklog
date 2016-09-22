<?php
include_once "../classes/Timer.php";
/**
 * Ajax file to process timer deletion
 * @author Edwin
 */
class DelTimer
{
    public static function process()
    {
        if (!isset($_GET['tid'])) { return 'err'; }
        if (!is_numeric($_GET['tid'])) { return 'err'; }
        Timer::deleteById($_GET['tid']);
        return 'ok';
    }
}

echo DelTimer::process();
