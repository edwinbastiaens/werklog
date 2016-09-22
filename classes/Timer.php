<?php
include_once "PDOwrapper.php";

class Timer
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

    public function created()
    {
        return $this->row['created'];
    }

    public function creator()
    {
        return $this->row['creator'];
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
            "INSERT INTO `timerinterval` (`timerid`, `start`, `stop`)
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
     * retrieve one single instance.
     * On error returns null.
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
        return new Timer($row);
    }

    public static function getByGrantedId($uid, $visible="1")
    {
        if (!is_numeric($uid)){
            return array();
        }

        $clauses = array("tu.userid=?");
        $parms = array($uid);
        if (($visible != "" && (is_numeric($visible)))){
            $clauses[] = "t.visible=?";
            $parms[] = $visible;
        }

        $sql = "SELECT t.* FROM `timer` t "
            . "JOIN timeruser tu ON tu.timerid = t.id "
            . "WHERE 1=1 ";
        foreach($clauses as $clause){
            $sql .= " AND " . $clause;
        }
        $rows = PDOwrapper::getRows($sql,$parms);
        return self::rowsToTimers($rows);
    }

    public static function getByUserId($uid, $visible="1")
    {
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
        $rows = PDOwrapper::getRows($sql,$parms);
        return self::rowsToTimers($rows);
    }

    private static function rowsToTimers($rows)
    {
        $timers=array();
        if (($rows !== false) && (count($rows) > 0)) {
            foreach ($rows as $row){
                $timers[] = new Timer($row);
            }
        }
        return $timers;
    }
}
