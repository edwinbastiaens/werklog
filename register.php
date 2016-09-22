<?php
include_once "classes/MenuManager.php";
include_once "classes/MasterPageData.php";
include_once "classes/UserHandler.php";
include_once "classes/Mailer.php";
MenuManager::init("registreer");
MasterPageData::title("register");

class RegisterManager
{
    public static function getForm()
    {
        $ret = <<<FRM
<form method='post'>
    <h2>Registreren</h2>
    <input type='email' name='logonemail' required placeholder='email adres' /><br/>
    <input type='naam' name='naam' required placeholder='naam' /><br/>
    <input type='password' name='password' placeholder='password' required /><br/>
    <input type='password' name='password2' placeholder='herhaal password' required /><br/>
    <input type='submit' value='registreer' />
</form>
FRM;
        return $ret;
    }

    public static function processForm()
    {
        if (!isset($_POST['logonemail'])) {return "";}
        if (User::getUserByEmail($_POST['logonemail']) !== false) {
            return "Dit email adres is reeds in gebruik.";
        }
        if (strlen($_POST['password'])<6) {
            return "Paswoord is te eenvoudig. Gelieve een langer paswoord te kiezen";
        }
        if ($_POST['password'] != $_POST['password2']){
            return "Ingegeven paswoorden komen niet overeen";
        }
        User::create($_POST['logonemail'], $_POST['naam'], $_POST['password']);
        UserHandler::login($_POST['logonemail'], $_POST['password']);
        PDOwrapper::execute(
            "update timeruser set userid = (select id from user where email=?)"
            . "WHERE email = ?",
            array($_POST['logonemail'],$_POST['logonemail'])
        );
//        TimerUser::registerForEmail($_POST['logonemail']);
        $subject = "Je registratie op Tolima";
        $message = <<<MSG
            Beste,<br/><br/>
            Welkom op Tolima Werklogger.<br/><br/>
            Je bent nu succesvol geregistreerd op de werklogger van Tolima. 
            Je kan nu zelf je eigen werklogs gaan bijhouden en op basis hiervan
            correcte facturen opstellen voor je klanten.<br/>
            Je kan je opdrachtgevers lees toegang geven tot werklogs zodat zij
            de vooruitgang van je werk mee kunnen opvolgen.<br/><br/>
            Ben je een opdrachtgever dan kan je je aannemers vragen om hun werklogs
            met je te delen zodat je die samen kunt opvolgen.<br/><br/>
            veel succes,<br/>
            Tolima <a href='http://www.tolima.be/werklog'>Werklogger<a/>
MSG;
        Mailer::sendMail($_POST['logonemail'], $subject, $message);
        header("Location: index.php");
    }
}

$main = "";
$result =  RegisterManager::processForm();
if ($result === true){
    header("Location: index.php");
    exit;
}
if ($result != ""){
    $main .= "<div class='warning'>".$result."</div>";
}

$main .= RegisterManager::getForm();
MasterPageData::main($main);
include "masterpage.php";
