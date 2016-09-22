<?php
include_once "../classes/UserHandler.php";
include_once "../classes/User.php";
include_once "../classes/Timer.php";
include_once "../classes/TimeLib.php";
include_once "../classes/TimerUser.php";

class TimerDetailManager
{
    public static function process()
    {
       if (! isset($_GET['tid'])) { return "";}
       if (UserHandler::getUserId() == 0) {return "";}
       $currentUser = new User(UserHandler::getUserId());
       $timer = Timer::getById($_GET['tid']);

       $ret = "<h1>".$timer->title()."</h1>";
       $ret .= "<b>Creator</b> : " . $currentUser->name() . " " . $currentUser->email() . "<br/>";
       $ret .= "<b>Gestart op</b> : " . date("d/m/Y h:i:s", strtotime ($timer->created())). "<br/>";//
       $ret .= "<b>Totale looptijd</b> : " .TimeLib::secs2time($timer->totaltime()) . "<br/>";
       $ret .= "<b>Status :</b> " . (($timer->isRunning())? "lopende" : "on hold") . "<br/>";
       $ret .= "<hr/>";

       if ($timer->creator() == $currentUser->id()){
           $ret .= self::getTimerUserManagement($timer,$currentUser);
       }
       echo $ret. "<br/>";
    }

    public static function getTimerUserManagement($timer,$currentUser)
    {
        $timerid = $timer->id();
        $ret = "<h2>Rechtenbeheer</h2>";
        $tuRow = TimerUser::getOverviewForTimer($timerid);
        if (count($tuRow)>0){
            $ret .= "<table><tr><th>Naam</th>"
                . "<th>Email</th>"
                . "<th>Lezen</th>"
                . "<th>Schrijven</th></tr>";
            foreach($tuRow as $timerUser){
                if ($timerUser->userid() == null){
                    $name = "?";
                    $email = $timerUser->email();
                } else {
                    $user = User::getById($timerUser->userid());
                    $name = $user->name();
                    $email = $user->email();
                }
                $ret .= "<tr><td>".$name."</td>"
                    . "<td>".$email."</td>"
                    . "<td align='center'>".$timerUser->read()."</td>"
                    . "<td align='center'>".$timerUser->write()."</td>"
                    . "<td align='center'>"."</td></tr>";
            }
            $ret .= "</table><div id='add".$timerid."'><div>";
        }

        $ret .= <<<FRM
            <div class='form'>
            <input type='email' id='e{$timerid}' name='newtimeruser' required placeholder='email adres' />
            <input type='submit' id='d{$timerid}' value='toevoegen' />
            </div>
            <script>
                $('#d{$timerid}').click(function(){
                    $.ajax({
                        url: 'ajax/addTimerUser.php?tid={$timerid}&uid=' + $('#e{$timerid}').val(),
                        context:document.body
                    }).done(function(data){
                        if (data == 'ok'){
                            $('#add{$timerid}').append($('#e{$timerid}').val() + ' toegevoegd<br/>');
                            $('#e{$timerid}').val('');
                        }
                    });
                });
            </script>
FRM;
        return $ret;
    }
}

TimerDetailManager::process();

