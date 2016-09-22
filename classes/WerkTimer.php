<?php
include_once "PDOwrapper.php";

class WerkTimer
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

    public function title()
    {
        return $this->row['title'];
    }

    public function totaltime()
    {
        return $this->row['totaltime'];
    }

    public function runningSince()
    {
        return $this->row['runningsince'];
    }

    public function isRunning()
    {
        return ($this->runningSince() != null);
    }

    public function start()
    {
        if ($this->isRunning()) {return;}
        PDOwrapper::execute(
            "UPDATE `timer` SET runningsince=now() WHERE id=?",
            array($this->id())
        );
    }

    public function stop()
    {
        if (! $this->isRunning()) {return;}
        PDOwrapper::execute(
            "INSERT INTO `projects`.`timerinterval` (`timerid`, `start`, `stop`)
            VALUES (?,
            ( SELECT runningsince from `timer` where id=?),
            CURRENT_TIMESTAMP);",
            array($this->id(), $this->id())
        );

        PDOwrapper::execute(
            "UPDATE `timer` "
            . "SET totaltime=totaltime + UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(runningsince),"
            . "runningsince=null WHERE id=?",
            array($this->id())
        );

    }

    public static function create(
        $title,
        $userid
    ) {
        PDOwrapper::execute(
            "INSERT INTO `timer` (`title`, `creator`) VALUES (?,?);",
            array($title,$userid)
        );
    }

    public static function deleteById($tid)
    {
        PDOwrapper::execute(
            "DELETE FROM `timer`WHERE id=?",
            array($tid)
        );
    }

    /**
     * retrieve one single instance
     * on error return null
     * @param type $tid
     * @return type
     */
    public static function getById($tid)
    {
        if (is_null($tid)) {return null;}
        if (!is_numeric($tid)) {return null;}
        $row = PDOwrapper::getRow(
            "SELECT * FROM `timer` WHERE id=?",
            array($tid)
        );
        if (($row == null) || (!$row)) {return null;}
        return new WerkTimer($row);
    }

    public static function getByUserId($uid, $visible="1")
    {
        echo "HOIOIOIOIOIO";exit;
        if (!is_numeric($uid)){
            return array();
        }

        $clauses = array("creator=?");
        $parms = array($uid);
        if (($visible != "" && (is_numeric($visible)))){
            $clauses[] = "visible=?";
            $parms[] = $visible;
        }
        $sql = "select * from `timer` WHERE 1=1 ";
        foreach($clauses as $clause){
            $sql .= " AND " . $clause;
        }
        echo $sql;
        var_dump($parms);
        exit;
        $rows = PDOwrapper::getRows($sql,$parms);
        $timers=array();
        foreach ($rows as $row){
            $timers[] = new WerkTimer($row);
        }
        return $timers;
    }
}
