<?php
include_once "../classes/TimerUser.php";
include_once "../classes/User.php";
include_once "../classes/Timer.php";
include_once "../classes/Mailer.php";
/**
 * Ajax file to process timeruser addition
 * uid mag zowel id als email zijn
 * @author Edwin
 */
class AddTimerUser
{
    public static function process()
    {
        if (!isset($_GET['tid'])) { return 'err'; }
        if (!is_numeric($_GET['tid'])) { return 'err'; }
        if (!isset($_GET['uid'])) { return 'err'; }
        if (is_numeric($_GET['uid'])) {
            TimerUser::create($_GET['tid'], $_GET['uid']);
        } else {
            TimerUser::createByEmail($_GET['tid'], $_GET['uid']);
            
            //ophalen naam van eignaar van timer
            $timer = Timer::getById($_GET['tid']);
            $userOwner = User::getById($timer->creator());
            $ownername = $userOwner->name();
            $subject = "U werd uitgenodigd door " 
                . $ownername . " op http://www.tolima.be/werklog";
            $message = <<<MSG
Beste,<br/><br/>
Je werd uitgenodigd door {$ownername}
om zijn werklog mee op te volgen op http://www.tolima.be/werklog
Het enige wat je hiervoor moet doen is je registreren op http://www.tolima.be/werklog
met je emailadres {$_GET['uid']}.
Eenmaal inglogd kan je meteen de werklog van {$ownername} opvolgen.<br/><br/>
veel succes!<br/>
Tolima
MSG;
            Mailer::sendMail($_GET['uid'], $subject, $message);
        }
        return 'ok';
    }
}

echo AddTimerUser::process();
