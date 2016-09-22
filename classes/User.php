<?php
include_once "PDOwrapper.php";
/**
 *
 * @author Edwin
 */
class User
{
    private $row;
    public function __construct($data)
    {
        if (is_numeric($data)){
            $this->row = self::getUserRowById($data);
        } else if (is_array($data)){
            $this->row = $data;
        }
    }

    public static $users = array();
    public static function getById($id){
        if (!is_numeric($id)) return null;
        if (! isset(self::$users[$id])){
            self::$users[$id] = new User($id);
        }
        return self::$users[$id];
    }

    private static function getUserRowById($id)
    {
        if (!is_numeric($id)) return false;
        $row = PDOwrapper::getRow(
            "SELECT * from user WHERE id=?",
            array($id));
        return $row;
    }

    public static function getUserByEmail($email)
    {
        $row = PDOwrapper::getRow(
            "SELECT * from user WHERE email=?",
            array($email));
        if ($row == false){ return false;}
        return new User($row);
    }

    public static function create($email,$name,$password)
    {
        $exists = (self::getUserByEmail($email) !== false);
        if ($exists) { return false; }
        PDOwrapper::execute(
            "INSERT INTO user (email,name,password) VALUES (?,?,?)",
            array($email,$name,md5($password))
        );
        return true;
    }

    public function name()
    {
        return $this->row['name'];
    }

    public function email()
    {
        return $this->row['email'];
    }

    public function id()
    {
        return $this->row['id'];
    }

    private function password()
    {
        return $this->row['password'];
    }

    public function setPassword($newPassword)
    {
        if ( ($newPassword == null) 
            || (!is_string($newPassword))
            || ($newPassword == "")) {
            return false;
        }
        PDOwrapper::execute(
            "update user set password = ? where id = ?",
            array(md5($newPassword), $this->id())
        );
    }

    public function checkPassword($password)
    {
        return (md5($password) === $this->password());
    }
}
