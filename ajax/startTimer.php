<?php
include_once "../classes/Timer.php";
/**
 * Ajax file to process timer start
 * @author Edwin
 */
class StartTimer
{
    public static function process()
    {
        if (!isset($_GET['tid'])) { return 'err'; }
        if (!is_numeric($_GET['tid'])) { return 'err'; }
        $timer = Timer::getById($_GET['tid']);
        if ($timer == null) { return 'err'; }
        $timer->start();
        return 'ok';
    }
}
echo StartTimer::process();
