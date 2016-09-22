<?php
include_once "classes/MenuManager.php";
include_once "classes/UserHandler.php";
include_once "classes/PDOwrapper.php";
include_once "classes/Timer.php";
include_once "classes/TimeLib.php";
include_once "classes/MasterPageData.php";

MenuManager::init();
class TimerUITF
{
    public static function processCreationForm()
    {
        if (! isset($_POST['crftitle'])) {return;}
        Timer::create($_POST['crftitle'], UserHandler::getUserId());
    }

    public static function creationForm()
    {
        $ret = <<<FRM
<form method='post'>
    <h2>Nieuwe werk-timer toevoegen</h2>
    <input name='crftitle' required placeholder='timer naam' />
    <input type='submit' value='Toevoegen' />
</form>
FRM;
        return $ret;
    }

    public static function getTimerOverview()
    {
        $ret = "";
        $timers = Timer::getByUserId(UserHandler::getUserId());
        foreach($timers as $timer){
            $tm = ($timer->isRunning())? "stop":"start";
            $ret .= "<div class='timer' id='t".$timer->id()."'>" .
                $timer->title()
                . "<span class='deltimer' tid='".$timer->id()."' >X</span>"
                . "<span class='timeraction ".$tm."timer' "
                    . "tid='".$timer->id()."'>".ucfirst($tm)
                ."</span>"
                . "<span class='timerdetails' tid='".$timer->id()."'><img src='images/write.png' width='20px' /></span>"
                ."<span class='totaltime' tid='".$timer->id()."'>".TimeLib::secs2time($timer->totaltime())."</span>"
            . "</div><div class='details' tid='".$timer->id()."'></div>";
        }
        return $ret;
    }

    public static function getGrantedOverview()
    {
        $ret = "";
        $timers = Timer::getByGrantedId(UserHandler::getUserId());
        foreach($timers as $timer){
            $tm = ($timer->isRunning())? "lopend":"on hold";
            $ret .= "<div class='timer' id='t".$timer->id()."'>" .
                $timer->title()
                . "<span class='timersituation' "
                    . "tid='".$timer->id()."'>".ucfirst($tm)
                ."</span>"
                . "<span class='timerdetails' tid='".$timer->id()."'><img src='images/watch.png' width='20px' /></span>"
                ."<span class='totaltime' tid='".$timer->id()."'>".TimeLib::secs2time($timer->totaltime())."</span>"
            . "</div><div class='details' tid='".$timer->id()."'></div>";
        }
        return $ret;
    }
}
TimerUITF::processCreationForm();

if (!UserHandler::loggedIn()){
    $main = <<<FRM
<form action='logon.php' method='post'>
    <h2>Je bent nog niet ingelogd</h2>
    <input type='email' name='logonemail' required placeholder='email adres' /><br/>
    <input type='password' name='password' required />
    <input type='submit' value='Login' />
</form>
FRM;
} else {
    $main =  TimerUITF::creationForm()
        . "<hr/>"
        ."<div id='toverview'>"
        . TimerUITF::getTimerOverview()
        . TimerUITF::getGrantedOverview()
        . "</div>";
}
MasterPageData::main($main);
include "masterpage.php";
