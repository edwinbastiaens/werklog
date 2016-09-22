<?php
class PDOwrapper
{
    public static $db = null;
    public static $insertId = "";
    public static $results = null;
    public static $err = "";
    public static $row_count = null;

    public static function init()
    {
        if (self::$db == null) {
            self::$db = new PDO(
                'mysql:host=localhost;dbname=projects;charset=utf8',
                'projectusr',
                'BSvS6hj86C9TxGxB'
            );

//            self::$db = new PDO(
//                'mysql:host=localhost;dbname=tolimabe_edb;charset=utf8',
//                'tolimabe_eddy',
//                'g983!498.0wRTEhv'
//            );
        }
    }

    public static function close()
    {
        if (self::$db != null)
            self::$db = null;
    }

    private static function performQuery($sql)
    {
        try {
            self::$db->query($sql);
        } catch (PDOException $ex) {
            self::$err = $ex->getMessage();
        }
    }

    private static function getResults($sql, $getrowcnt = false)
    {
        try {
            $stmt = self::$db->query($sql);
            if ($getrowcnt)
                self::$row_count = $stmt->rowCount();
            self::$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            self::$err = $ex->getMessage();
        }
    }

    public static function insert($sql)
    {
        try {
            $result = self::$db->exec($sql);
            self::$insertId = self::$db->lastInsertId();
            return self::$insertId;
        } catch (PDOException $ex) {
            self::$err = $ex->getMessage();
            return 0;
        }
    }

    public static function execute($sql, $arr=array())
    {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($arr);
    }

    private static function fetchResult($stmt, $cnt)
    {
        self::$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        self::$row_count = sizeof(self::$results);
        if (self::$row_count > 0) {
            if ($cnt == "1")
                return self::$results[0];
            return self::$results;
        }
        return false;
    }

    public static function getRow($sql, $parmarray=array())
    {
        $stmt = PDOwrapper::$db->prepare($sql);
        $stmt->execute($parmarray);
        return PDOwrapper::fetchResult($stmt, 1);
    }

    public static function getRows($sql, $parmarray=array())
    {
        $stmt = PDOwrapper::$db->prepare($sql);
        $stmt->execute($parmarray);
        return PDOwrapper::fetchResult($stmt, "n");
    }
}

PDOwrapper::init();
