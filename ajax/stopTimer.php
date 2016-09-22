<?php
include_once "../classes/Timer.php";
/**
 * Ajax file to process timer stop
 * @author Edwin
 */
class StopTimer
{
    public static function process()
    {
        if (!isset($_GET['tid'])) { return 'err'; }
        if (!is_numeric($_GET['tid'])) { return 'err'; }
        $timer = Timer::getById($_GET['tid']);
        if ($timer == null) { return 'err'; }
        $timer->stop();
        return 'ok';
    }
}

echo StopTimer::process();
