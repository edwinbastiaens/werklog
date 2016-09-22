<?php
include_once "PDOwrapper.php";

class TimerUser
{
    private $row;

    public function __construct($row)
    {
        $this->row = $row;
    }

    public function id()
    {
        return $this->row['id'];
    }

    public function timerid()
    {
        return $this->row['timerid'];
    }

    public function userid()
    {
        return $this->row['userid'];
    }

    public function read()
    {
        return $this->row['read'];
    }

    public function write()
    {
        return $this->row['write'];
    }

    public function email()
    {
        return $this->row['email'];
    }

    public static function create($timerid,$userid)
    {
        PDOwrapper::execute(
            "insert into timeruser (timerid,userid) VALUES (?,?)",
            array($timerid,$userid)
        );
    }

    public static function registerForEmail($email)
    {
        PDOwrapper::execute(
            "update timeruser set userid = (select id from user where email=?)"
            . "WHERE email = ?",
            array($email,$email)
        );
    }

    public static function createByEmail($timerid,$email)
    {
        PDOwrapper::execute(
            "insert into timeruser (timerid,email) VALUES (?,?)",
            array($timerid,$email)
        );
    }

    public static function getOverviewForTimer($tid)
    {
        if ($tid == null) {return array();}
        if (!is_numeric($tid)) {return array();}
        $rows = PDOwrapper::getRows(
            "SELECT * FROM timeruser WHERE timerid = ?",
            array($tid)
        );

        $timerusers=array();
        if (($rows !== false) && (count($rows) > 0)) {
            foreach ($rows as $row){
                $timerusers[] = new TimerUser($row);
            }
        }
        return $timerusers;
    }
}
