<?php


class Dbconnection
{
    const host='localhost';
    const dbUsername='root';
    const password='';
    public $connect;
    public $dbName='te';
    public function __construct(){
        try{
            $this->connect=new PDO('mysql:host=' . self::host . ';dbname=' . $this->dbName . ';charset=utf8', self::dbUsername, self::password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        }
        catch(PDOException $exception){
            echo $exception->getMessage();
        }
    }
    public function __destruct(){
        $this->connect=Null;
    }
}
$er=new Dbconnection();