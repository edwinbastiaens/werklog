<?php
include_once "classes/MenuManager.php";
include_once "classes/MasterPageData.php";
include_once "classes/UserHandler.php";

MenuManager::init("logon");
MasterPageData::title("Logon");

class LogonManager
{
    public static function getForm()
    {
        $ret = <<<FRM
<form method='post'>
    <h2>Inloggen</h2>
    <input type='email' name='logonemail' required placeholder='email adres' /><br/>
    <input type='password' name='password' required />
    <input type='submit' value='Login' />
</form>
FRM;
        return $ret;
    }

    public static function processForm()
    {
        if (!isset($_POST['logonemail'])) {return true;}
        if (UserHandler::login($_POST['logonemail'],$_POST['password'])){
            header("Location: index.php");
        } else {
            return false;
        }
    }
}
$main = "";
if (! LogonManager::processForm()){
    $main .= "<div class='warning'>Username or password are wrong</div>";
}
$main .= LogonManager::getForm();
MasterPageData::main($main);
include "masterpage.php";
