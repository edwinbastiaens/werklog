<?php
include_once "../classes/Timer.php";
include_once "../classes/TimeLib.php";
/**
 *
 * @author Edwin
 */
class GetTotalTime
{
     public static function process()
    {
        if (!isset($_GET['tid'])) { return 'err'; }
        if (!is_numeric($_GET['tid'])) { return 'err'; }
        $timer = Timer::getById($_GET['tid']);
        if ($timer == null) { return 'err'; }
        return TimeLib::secs2time($timer->totaltime());
    }
}
echo GetTotalTime::process();
